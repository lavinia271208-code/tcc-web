<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Mostra o formulário de login

    public function index()
    {
        return view('login');
    }

    // login do usuario
    public function login(Request $request)
    {
        // validate() devolve apenas os campos validados: ['email' => ..., 'password' => ...]

        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Auth::attempt procura o usuário pelo e-mail e confere a senha com o hash do banco

        if (Auth::attempt($credentials)) {
            // Gera novo ID de sessão após o login (evita "session fixation")
            $request->session()->regenerate();

            // Se o usuário for administrador, redireciona pro dashboard admin
            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard');
            }

            // se for usuário comum ele redireciona p/ a home
            return redirect()->route('home');
        }
        // Falha: volta ao login com mensagem de erro
        return back()
            ->withErrors(['email' => 'E-mail ou senha inválidos.'])
            ->onlyInput('email');
    }

}