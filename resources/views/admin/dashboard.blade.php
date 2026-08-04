@extends('layouts.app')

@section('content')
<div style="background-color: #FBF5F0; min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div class="container d-flex flex-column align-items-center text-center" style="padding: 30px; max-width: 500px;">
        <h1 style="font-family: 'Playfair Display', serif;">Bem-vinda, Administradora!</h1>
        <p class="text-muted fs-5">O que você gostaria de fazer hoje?</p>
        <hr class="w-100 mb-5">
        <div class="w-100">

            <a href="{{ route('admin.lista_agendamentos.create') }}"
               class="btn py-2 mb-3 w-100"
               style="background-color:#e6b0a2; color:#000; font-weight:bold; font-size: 1.05rem; display: block;">Novo Agendamento</a>

            <a href="{{ route('admin.lista_agendamentos') }}"
               class="btn py-2 mb-3 w-100"
               style="background-color:#e6b0a2; color:#000; font-weight:bold; font-size: 1.05rem; display: block;">Lista de Agendamentos</a>

            <a href="{{ route('admin.servicos') }}"
               class="btn py-2 mb-3 w-100"
               style="background-color:#e6b0a2; color:#000; font-weight:bold; font-size: 1.05rem; display: block;">Cadastrar Serviço</a>

            <a href="{{ route('admin.bloqueios.index') }}"
               class="btn py-2 mb-3 w-100"
               style="background-color:#e6b0a2; color:#000; font-weight:bold; font-size: 1.05rem; display: block;">Bloquear Horário</a>
        </div>
    </div>
</div>
@endsection