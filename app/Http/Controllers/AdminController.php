<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;

class AdminController extends Controller
{
    //listar agendamentos
    public function index()
{
    $agendamentos = \App\Models\Agendamento::all();
    $totalAgendamentos = $agendamentos->count();
    $totalServicos = \App\Models\Servico::count();

    return view('admin.dashboard', compact(
        'agendamentos',
        'totalAgendamentos',
        'totalServicos'
    ));
}
    //aprovar
    public function aprovar($id)
    {
        $agendamento = Agendamento::findOrFail($id);
        $agendamento->status = 'confirmado';
        $agendamento->save();

        return back();
    }

    //recusar
    public function recusar($id)
    {
        $agendamento = Agendamento::findOrFail($id);
        $agendamento->status = 'cancelado';
        $agendamento->save();

        return back();
    }
}