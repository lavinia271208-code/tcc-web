@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Agendamentos</h2>

    <table class="table">
        <tr>
            <th>Cliente</th>
            <th>Serviço</th>
            <th>Data</th>
            <th>Hora</th>
        </tr>

        @foreach($agendamentos as $ag)
        <tr>
            <td>{{ $ag->user->name }}</td>
            <td>{{ $ag->servico->nome }}</td>
            <td>{{ $ag->data }}</td>
            <td>{{ $ag->hora }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection