@extends('layouts.app')

@section('content')

<div class="make_apppointment_area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10">
                <div class="appoint_ment_form">

                    <div class="section_title text-center mb-55">
                        <h3>Entrar na sua conta</h3>
                        <p>Digite seus dados para acessar</p>
                    </div>

                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf

                        <div class="single_field">
                            <input 
                                type="email" 
                                name="email" 
                                placeholder="Seu e-mail" 
                                value="{{ old('email') }}"
                                required>
                        </div>

                        <div class="single_field">
                            <input 
                                type="password" 
                                name="password" 
                                placeholder="Senha" 
                                required>
                        </div>

                        <div class="single_field text-center">
                            <a href="{{ route('admin.dashboard') }}" class="boxed-btn3">Entrar</a>
                        </div>

                        <p class="text-center mt-20">Não tem uma conta? <a href="{{ route('cadastro') }}" style="text-decoration: none; color: #e6b0a2; font-weight: bold;">Cadastre-se</a></p>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection