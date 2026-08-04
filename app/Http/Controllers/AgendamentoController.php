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

    public function getEvents()
    {
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
    // tela home
    public function create()
    {
        $usuarios = User::orderBy('name')->get();
        $servicos = Servico::orderBy('nome')->get();

        return view('home', compact(
            'usuarios',
            'servicos'
        ));
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'servico_id' => 'required|exists:servicos,id',
            'data_hora' => 'required|date',
        ]);

        $inicio = Carbon::parse($request->data_hora);
        $servico = Servico::findOrFail($request->servico_id);
        $fim = (clone $inicio)->addMinutes($servico->duracao_minutos);

        $bloqueado = HorarioBloqueado::where(function ($query) use ($inicio, $fim) {
            $query->where('data_hora_inicio', '<', $fim)
                  ->where('data_hora_fim', '>', $inicio);
        })->exists();

        if ($bloqueado) {
            return back()->withInput()->withErrors([
                'data_hora' => 'O horário selecionado está indisponível ou bloqueado.'
            ]);
        }
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

    // salva agendamento
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

        $bloqueado = HorarioBloqueado::where(function ($query) use ($inicio, $fim) {
            $query->where('data_hora_inicio', '<', $fim)
                  ->where('data_hora_fim', '>', $inicio);
        })->exists();

        if ($bloqueado) {
            return back()->withInput()->withErrors([
                'data_hora' => 'Este horário está bloqueado na agenda!'
            ]);
        }
        $agendado = Agendamento::where(function ($query) use ($inicio, $fim) {
            $query->where('data_hora', '<', $fim)
                  ->where('data_hora', '>=', $inicio);
        })->exists();

        if ($agendado) {
            return back()->withInput()->withErrors([
                'data_hora' => 'Já existe outro agendamento neste horário!'
            ]);
        }
        $usuario = User::whereRaw('LOWER(name) = ?', [strtolower($request->cliente_nome)])->first();

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

    public function destroy($id)
    {
        $agendamento = Agendamento::findOrFail($id);
        $agendamento->delete();

        return redirect()
            ->route('admin.lista_agendamentos')
            ->with('success', 'Agendamento excluído com sucesso!');
    }

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