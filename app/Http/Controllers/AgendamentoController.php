<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    //tela de agendamento (form)
    public function create()
    {
        return view('home');
    }

    //método de envio do form
    public function store()
    {
        return view('home');
    }
}