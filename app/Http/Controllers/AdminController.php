<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Servico;
use App\Models\Agendamento;

/**
 * Telas da administradora: dashboard, CRUD de serviços e lista de agendamentos.
 * Todas as rotas daqui estão protegidas por 'auth' + 'admin' (routes/web.php).
 */
class AdminController extends Controller
{
    public function dashboard()
    {
        $totalServicos = Servico::count();
        $totalAgendamentos = Agendamento::count(); // não conta os "apagados" (soft delete)

        // O compact() cria um array associativo com as variáveis informadas.
        // Exemplo: compact('a', 'b') equivale a ['a' => $a, 'b' => $b].
        // No caso abaixo, ele envia as variáveis do controller para a view.
        return view('admin.dashboard', compact(
            'totalServicos',
            'totalAgendamentos'
        ));
    }
    // Lista de serviços (ordem alfabética)

    public function servicos()
    {
        $servicos = Servico::orderBy('nome')->get();

        return view('admin.servicos', compact('servicos'));
    }
    // Cadastra um novo serviço

    public function storeServico(Request $request)
    {
        // Se alguma regra falhar, o Laravel volta para a página anterior com os erros

        $request->validate([
            'nome'      => 'required|string|max:255',
            'preco'     => 'required|string',
            'duracao'   => 'required|numeric|min:1',
            'descricao' => 'nullable|string',
        ]);

        $servico = new Servico();
        $servico->nome             = $request->nome;
        $servico->preco            = $this->converterPreco($request->preco);
        $servico->duracao_minutos  = $request->duracao; // campo do form é "duracao", coluna é "duracao_minutos"
        $servico->descricao        = $request->descricao;
        $servico->save();

        return redirect()
            ->back()
            ->with('success', 'Serviço cadastrado com sucesso!'); // mensagem exibida uma vez na view
    }

    // Tela de edição de um serviço.

    public function editServico($id)
    {
        $servico = Servico::findOrFail($id); // erro se não existir

        return view('admin.servicos-edit', compact('servico'));
    }

    // atualiza um serviço existente
    public function updateServico(Request $request, $id)
    {
        $request->validate([
            'nome'      => 'required|string|max:255',
            'preco'     => 'required|string',
            'duracao'   => 'required|numeric|min:1',
            'descricao' => 'nullable|string',
        ]);

         // find() devolve null se o id não existir (ao contrário de findOrFail, que dá 404);
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

    // Exclui um serviço, desde que não tenha agendamentos vinculados

    public function destroyServico($id)
    {
        $servico = Servico::find($id);

        // exists() faz um SELECT barato só para saber se há ao menos um registro.
        // Protege a integridade: agendamentos dependem do serviço (chave estrangeira).
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

    // Lista TODOS os agendamentos (mais recentes primeiro).
    // Não está ligado a nenhuma rota: quem atende a tela é listaAgendamentos(), mais abaixo.
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

    // Converte preço do formato brasileiro para número: "1.234,56" -> 1234.56

    private function converterPreco(string $valor): float
    {
        $valor = str_replace('.', '', $valor); // remove separador de milhar
        $valor = str_replace(',', '.', $valor); // vírgula decimal vira ponto

        return (float) $valor;
    }

    // Tela "Lista de agendamentos": mostra só os agendamentos de HOJE, por horário

    public function listaAgendamentos()
    {
        // with(['user','servico']) carrega cliente e serviço de uma vez (eager loading),
        // evitando uma consulta extra por linha da tabela (problema N+1)
        $agendamentos = Agendamento::with(['user', 'servico'])
            ->whereDate('data_hora', \Carbon\Carbon::today())
            ->orderBy('data_hora')
            ->get();

        $servicos = Servico::orderBy('nome')->get();

        return view('admin.lista_agendamentos', compact('agendamentos', 'servicos'));
    }
}