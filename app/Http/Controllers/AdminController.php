<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Servico;
use App\Models\Agendamento;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalServicos = Servico::count();
        $totalAgendamentos = Agendamento::count();

        return view('admin.dashboard', compact(
            'totalServicos',
            'totalAgendamentos'
        ));
    }

    public function servicos()
    {
        $servicos = Servico::orderBy('nome')->get();

        return view('admin.servicos', compact('servicos'));
    }

    public function storeServico(Request $request)
    {
        $request->validate([
            'nome'      => 'required|string|max:255',
            'preco'     => 'required|string',
            'duracao'   => 'required|numeric|min:1',
            'descricao' => 'nullable|string',
        ]);

        $servico = new Servico();
        $servico->nome             = $request->nome;
        $servico->preco            = $this->converterPreco($request->preco);
        $servico->duracao_minutos  = $request->duracao;
        $servico->descricao        = $request->descricao;
        $servico->save();

        return redirect()
            ->back()
            ->with('success', 'Serviço cadastrado com sucesso!');
    }

    public function editServico($id)
    {
        $servico = Servico::findOrFail($id);

        return view('admin.servicos-edit', compact('servico'));
    }

    public function updateServico(Request $request, $id)
    {
        $request->validate([
            'nome'      => 'required|string|max:255',
            'preco'     => 'required|string',
            'duracao'   => 'required|numeric|min:1',
            'descricao' => 'nullable|string',
        ]);

        $servico = Servico::find($id);
        $servico->nome             = $request->nome;
        $servico->preco            = $this->converterPreco($request->preco);
        $servico->duracao_minutos  = $request->duracao;
        $servico->descricao        = $request->descricao;
        $servico->save();

        return redirect()
            ->back()
            ->with('success', 'Serviço atualizado com sucesso!');
    }

    public function destroyServico($id)
    {
        $servico = Servico::find($id);

        if ($servico->agendamentos()->exists()) {
            return redirect()
                ->back()
                ->with('error', 'Não é possível excluir este serviço porque já existem agendamentos vinculados a ele.');
        }

        $servico->delete();

        return redirect()
            ->back()
            ->with('success', 'Serviço excluído com sucesso!');
    }

    public function agendamentos()
    {
        $agendamentos = Agendamento::orderBy('created_at', 'desc')->get();

        $usuarios = User::orderBy('name')->get();

        $servicos = Servico::orderBy('nome')->get();

        return view('admin.lista_agendamentos', compact(
            'agendamentos',
            'usuarios',
            'servicos'
        ));
    }

    private function converterPreco(string $valor): float
    {
        $valor = str_replace('.', '', $valor); 
        $valor = str_replace(',', '.', $valor);

        return (float) $valor;
    }

    public function listaAgendamentos()
    {
        $agendamentos = Agendamento::with(['user', 'servico'])
            ->whereDate('data_hora', \Carbon\Carbon::today())
            ->orderBy('data_hora')
            ->get();

        $servicos = Servico::orderBy('nome')->get();

        return view('admin.lista_agendamentos', compact('agendamentos', 'servicos'));
    }
}