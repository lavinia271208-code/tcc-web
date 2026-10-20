<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HorarioBloqueado;

/**
 * CRUD dos bloqueios de horário (períodos em que a profissional não atende).
 * Os bloqueios criados aqui são respeitados na hora de agendar.
 */
class HorarioBloqueadoController extends Controller
{
    // Lista os bloqueios, do mais recente para o mais antigo
    public function index()
    {
        $bloqueios = HorarioBloqueado::orderBy('data_hora_inicio', 'desc')->get();

        return view('admin.bloqueios', compact('bloqueios'));
    }
    // Cria um bloqueio

    public function store(Request $request)
    {
        // 'after:data_hora_inicio' garante que o fim vem depois do início.
        // O segundo array personaliza a mensagem de erro dessa regra.
        $request->validate([
            'data_hora_inicio' => 'required|date',
            'data_hora_fim'    => 'required|date|after:data_hora_inicio',
            'motivo'           => 'nullable|string|max:255',
        ], [
            'data_hora_fim.after' => 'A data/hora de término deve ser posterior à data/hora de início.'
        ]);

        HorarioBloqueado::create([
            'user_id'          => auth()->id(), 
            'data_hora_inicio' => $request->data_hora_inicio,
            'data_hora_fim'    => $request->data_hora_fim,
            'motivo'           => $request->motivo,
        ]);

        return redirect()
            ->route('admin.bloqueios.index')
            ->with('success', 'Horário bloqueado com sucesso!');
    }
    // Remove o bloqueio (soft delete), liberando o horário na agenda

    public function destroy($id)
    {
        $bloqueio = HorarioBloqueado::findOrFail($id);
        $bloqueio->delete();

        return redirect()
            ->route('admin.bloqueios.index')
            ->with('success', 'Bloqueio removido com sucesso!');
    }
    // Edita um bloqueio (mesmas regras do cadastro; user_id original é mantido)

    public function update(Request $request, $id)
    {
        $request->validate([
            'data_hora_inicio' => 'required|date',
            'data_hora_fim'    => 'required|date|after:data_hora_inicio',
            'motivo'           => 'nullable|string|max:255',
        ], [
            'data_hora_fim.after' => 'A data/hora de término deve ser posterior à data/hora de início.'
        ]);

        $bloqueio = HorarioBloqueado::findOrFail($id);

        $bloqueio->update([
            'data_hora_inicio' => $request->data_hora_inicio,
            'data_hora_fim'    => $request->data_hora_fim,
            'motivo'           => $request->motivo,
        ]);

        return redirect()
            ->route('admin.bloqueios.index')
            ->with('success', 'Bloqueio atualizado com sucesso!');
    }
}