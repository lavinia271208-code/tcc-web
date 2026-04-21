<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar formulário de cadastro
    public function showCadastro()
    {
        return view('cadastro');
    }

    // Processar cadastro
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telefone' => 'required|string',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'password' => Hash::make($request->password),
        ]);

        // Opcional: fazer login automático após cadastro
        auth()->login($user);

        return redirect()->route('home')->with('success', 'Cadastro realizado com sucesso!');
    }

    // Mostrar formulário de login
    public function showLogin()
    {
        return view('login');
    }
}
