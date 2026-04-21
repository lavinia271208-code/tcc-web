@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Serviços</h2>

    <form method="POST" action="{{ route('admin.servicos.store') }}">
        @csrf
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="text" name="preco" placeholder="Preço" required>

        <select name="tipo">
            <option value="maquiagem">Maquiagem</option>
            <option value="penteado">Penteado</option>
        </select>

        <button type="submit">Cadastrar</button>
    </form>

    <hr>

    <table class="table">
        <tr>
            <th>Nome</th>
            <th>Preço</th>
            <th>Tipo</th>
        </tr>

        @foreach($servicos as $servico)
        <tr>
            <td>{{ $servico->nome }}</td>
            <td>R$ {{ $servico->preco }}</td>
            <td>{{ $servico->tipo }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection