<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Servico;
use App\Models\Agendamento;
use App\Models\HorarioBloqueado;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AgendamentoController extends Controller
{
    public function index()
    {
        $agendamentos = Agendamento::whereDate('data_hora', Carbon::today())
                            ->orderBy('data_hora', 'asc')
                            ->get();

        return view('admin.lista_agendamentos', compact('agendamentos'));
    }

    // Devolve os agendamentos em JSON no formato do FullCalendar (id, title, start)

    public function getEvents()
    {
        // Só 'servico' é carregado; 'user' será buscado um por um dentro do map (N+1).
        // with(['servico','user']) resolveria.
        $agendamentos = Agendamento::with('servico')->get();

        $events = $agendamentos->map(function ($agendamento) {
            return [
                'id'    => $agendamento->id,
                'title' => ($agendamento->user->name ?? $agendamento->cliente_nome) . ' - ' . $agendamento->servico->nome,
                'start' => $agendamento->data_hora->toIso8601String(),
            ];
        });

        return response()->json($events);
    }
    // Tela home: formulário de agendamento
    public function create()
    {
        $usuarios = User::orderBy('name')->get();
        $servicos = Servico::orderBy('nome')->get();

        return view('home', compact(
            'usuarios',
            'servicos'
        ));
    }

    // Salva o agendamento feito pela cliente na home

    public function store(Request $request)
    {
        // 'exists:tabela,coluna' confirma que o id realmente existe no banco

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'servico_id' => 'required|exists:servicos,id',
            'data_hora' => 'required|date',
        ]);

        // Calcula o intervalo [inicio, fim) que o novo agendamento ocuparia
        $inicio = Carbon::parse($request->data_hora);
        $servico = Servico::findOrFail($request->servico_id);
        $fim = (clone $inicio)->addMinutes($servico->duracao_minutos);

        // 1) Existe algum bloqueio que se sobreponha a esse intervalo?
        $bloqueado = HorarioBloqueado::where(function ($query) use ($inicio, $fim) {
            $query->where('data_hora_inicio', '<', $fim)
                  ->where('data_hora_fim', '>', $inicio);
        })->exists();

        if ($bloqueado) {
            // back()->withInput() volta ao formulário mantendo o que foi digitado
            return back()->withInput()->withErrors([
                'data_hora' => 'O horário selecionado está indisponível ou bloqueado.'
            ]);
        }

        // 2) Existe outro agendamento começando dentro desse intervalo?
        $agendado = Agendamento::where(function ($query) use ($inicio, $fim) {
            $query->where('data_hora', '<', $fim)
                  ->where('data_hora', '>=', $inicio);
        })->exists();

        if ($agendado) {
            return back()->withInput()->withErrors([
                'data_hora' => 'Já existe um agendamento para este horário.'
            ]);
        }

        Agendamento::create([
            'user_id' => $request->user_id,
            'servico_id' => $request->servico_id,
            'data_hora' => $request->data_hora,
        ]);

        return redirect()
            ->route('home')
            ->with('success', 'Agendamento solicitado com sucesso!');
    }

    // agendar horário (adimin)
    public function createAgendamento()
    {
        $servicos = Servico::orderBy('nome')->get();

        return view('admin.criar_agendamentos', compact('servicos'));
    }

    // salva agendamento criado pelo admin
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'cliente_nome' => 'required|string|max:255',
            'servico_id' => 'required|exists:servicos,id',
            'data_hora' => 'required|date',
        ]);

        $inicio = Carbon::parse($request->data_hora);
        $servico = Servico::findOrFail($request->servico_id);
        $fim = (clone $inicio)->addMinutes($servico->duracao_minutos);

        // Mesma checagem de bloqueio do store()
        $bloqueado = HorarioBloqueado::where(function ($query) use ($inicio, $fim) {
            $query->where('data_hora_inicio', '<', $fim)
                  ->where('data_hora_fim', '>', $inicio);
        })->exists();

        if ($bloqueado) {
            return back()->withInput()->withErrors([
                'data_hora' => 'Este horário está bloqueado na agenda!'
            ]);
        }

        // Mesma checagem de conflito do store() (considera só o início dos outros)
        $agendado = Agendamento::where(function ($query) use ($inicio, $fim) {
            $query->where('data_hora', '<', $fim)
                  ->where('data_hora', '>=', $inicio);
        })->exists();

        if ($agendado) {
            return back()->withInput()->withErrors([
                'data_hora' => 'Já existe outro agendamento neste horário!'
            ]);
        }

        // Procura cliente pelo nome (sem diferenciar maiúsculas/minúsculas)
        $usuario = User::whereRaw('LOWER(name) = ?', [strtolower($request->cliente_nome)])->first();

        
        // Se não existe, cria um usuário "provisório": e-mail fictício único (o campo é
        // obrigatório e único) e senha aleatória, já que essa cliente nunca fará login.
        if (! $usuario) {
            $usuario = User::create([
                'name' => $request->cliente_nome,
                'email' => Str::slug($request->cliente_nome) . '_' . uniqid() . '@placeholder.com',
                'password' => bcrypt(Str::random(12)),
            ]);
        }

        Agendamento::create([
            'user_id' => $usuario->id,
            'servico_id' => $request->servico_id,
            'data_hora' => $request->data_hora,
        ]);

        return redirect()
            ->route('admin.lista_agendamentos')
            ->with('success', 'Agendamento cadastrado com sucesso!');
    }

    // Exclui o agendamento (soft delete: fica no banco com deleted_at preenchido)
    public function destroy($id)
    {
        $agendamento = Agendamento::findOrFail($id);
        $agendamento->delete();

        return redirect()
            ->route('admin.lista_agendamentos')
            ->with('success', 'Agendamento excluído com sucesso!');
    }

    // Edita/remarca um agendamento (mesma lógica do storeAdmin)

    public function update(Request $request, $id)
    {
        $request->validate([
            'cliente_nome' => 'required|string|max:255',
            'servico_id'   => 'required|exists:servicos,id',
            'data_hora'    => 'required|date',
        ]);

        $agendamento = Agendamento::findOrFail($id);

        $inicio  = Carbon::parse($request->data_hora);
        $servico = Servico::findOrFail($request->servico_id);
        $fim     = (clone $inicio)->addMinutes($servico->duracao_minutos);

        $bloqueado = HorarioBloqueado::where(function ($query) use ($inicio, $fim) {
            $query->where('data_hora_inicio', '<', $fim)
                ->where('data_hora_fim', '>', $inicio);
        })->exists();

        if ($bloqueado) {
            return back()->withInput()->withErrors([
                'data_hora' => 'Este horário está bloqueado na agenda!'
            ]);
        }

        // Igual aos anteriores, mas ignora o próprio agendamento (id != $id),
        // senão ele conflitaria consigo mesmo ao salvar sem mudar o horário.
        $conflito = Agendamento::where('id', '!=', $id)
            ->where(function ($query) use ($inicio, $fim) {
                $query->where('data_hora', '<', $fim)
                    ->where('data_hora', '>=', $inicio);
            })->exists();

        if ($conflito) {
            return back()->withInput()->withErrors([
                'data_hora' => 'Já existe outro agendamento neste horário!'
            ]);
        }
        
        // Busca ou cria a cliente pelo nome, igual ao storeAdmin

        $usuario = User::whereRaw('LOWER(name) = ?', [strtolower($request->cliente_nome)])->first();

        if (! $usuario) {
            $usuario = User::create([
                'name'     => $request->cliente_nome,
                'email'    => Str::slug($request->cliente_nome) . '_' . uniqid() . '@placeholder.com',
                'password' => bcrypt(Str::random(12)),
            ]);
        }

        $agendamento->update([
            'user_id'    => $usuario->id,
            'servico_id' => $request->servico_id,
            'data_hora'  => $request->data_hora,
        ]);

        return redirect()
            ->route('admin.lista_agendamentos')
            ->with('success', 'Agendamento atualizado com sucesso!');
    }
}