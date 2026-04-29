<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    //mostra form de cadastro
    public function showCadastro()
    {
        return view('cadastro');
    }

    //cadastro
    public function store()
    {
        return view('cadastro');
    }

    //mostra formnde login
    public function showLogin()
    {
        return view('login');
    }
}