<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HorarioBloqueado;

class HorarioBloqueadoController extends Controller
{
    public function index()
    {
        $bloqueios = HorarioBloqueado::orderBy('data_hora_inicio', 'desc')->get();

        return view('admin.bloqueios', compact('bloqueios'));
    }

    public function store(Request $request)
    {
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

    public function destroy($id)
    {
        $bloqueio = HorarioBloqueado::findOrFail($id);
        $bloqueio->delete();

        return redirect()
            ->route('admin.bloqueios.index')
            ->with('success', 'Bloqueio removido com sucesso!');
    }

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