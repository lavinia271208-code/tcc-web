<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;
use App\Models\Servico;

class AgendamentoController extends Controller
{
    // 📅 Tela de agendamento (Exibe o formulário)
    public function create()
    {
        $servicos = Servico::all();
        // Verifique se o seu arquivo na pasta views se chama 'home.blade.php'
        return view('home', compact('servicos'));
    }

    // 💾 Salvar agendamento (Processa o envio do formulário)
    public function store(Request $request)
    {
        // 🔒 validação
        $request->validate([
            'data' => 'required|date',
            'hora' => 'required',
            'servico_id' => 'required|exists:servicos,id'
        ]);

        // 🔗 juntar data + hora
        $dataHora = $request->data . ' ' . $request->hora;

        // 🚫 evitar horário duplicado
        $existe = Agendamento::where('data_hora', $dataHora)->exists();

        if ($existe) {
            return back()->with('error', 'Horário já está ocupado!');
        }

        // 💾 salvar no banco
        Agendamento::create([
            'user_id' => auth()->id() ?? 1, // Usa ID 1 se não estiver logado (para teste)
            'servico_id' => $request->servico_id,
            'data_hora' => $dataHora,
            'status' => 'pendente'
        ]);

        return back()->with('success', 'Agendamento realizado com sucesso!');
    }
}