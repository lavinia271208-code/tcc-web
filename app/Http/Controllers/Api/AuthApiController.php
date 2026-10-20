<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthApiController extends Controller
{
    // Nome dado ao token no banco (tabela personal_access_tokens)
    private const TOKEN_NAME = 'flutter-app';

    // POST /api/login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        // Hash::check compara a senha digitada com o hash salvo.
        // Mensagem única para "e-mail não existe" e "senha errada" 
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['E-mail ou senha inválidos.'],
            ]);
        }

        // um token por app: evita acumular tokens a cada login
        $user->tokens()->where('name', self::TOKEN_NAME)->delete();

        return response()->json(['data' => $this->payload($user)]);
    }

    // POST /api/cadastro
    public function cadastro(Request $request)
    {
        // 'confirmed' exige um campo "password_confirmation" igual à senha
        // 'unique:users,email' impede e-mail repetido
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // is_admin nunca vem do cliente: cadastro pela API é sempre cliente
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']), // nunca salvar senha em texto puro
        ]);
        // Já devolve o token: a cliente fica logada logo após o cadastro
        return response()->json(['data' => $this->payload($user)], 201);
    }

    // GET /api/user
    public function user(Request $request)
    {
        return response()->json(['data' => $this->userArray($request->user())]);
    }

    // POST /api/logout
    public function logout(Request $request)
    {
        // Apaga só o token usado nesta requisição (outros dispositivos continuam logados)
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso.']);
    }
    
    // Dados do usuário + token. O operador "+" em arrays junta os dois.
    private function payload(User $user): array
    {
        return $this->userArray($user) + [
            'token' => $user->createToken(self::TOKEN_NAME)->plainTextToken,
        ];
    }
    // Seleciona só os campos que podem ser expostos pela API
    private function userArray(User $user): array
    {
        return [
            'id'       => $user->id,
            'name'     => $user->name,
            'email'    => $user->email,
            'is_admin' => (bool) $user->is_admin,
        ];
    }
}