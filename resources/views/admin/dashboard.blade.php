@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Painel Admin</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card p-3">
                <h4>Agendamentos</h4>
                <p>{{ $totalAgendamentos }}</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h4>Serviços</h4>
                <p>{{ $totalServicos }}</p>
            </div>
        </div>
    </div>

    <hr>
    <h3>Agendamentos Pendentes</h3>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Data</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($agendamentos as $agendamento)
            <tr>
                <td>{{ $agendamento->id }}</td>
                <td>{{ $agendamento->data_hora }}</td>
                <td>{{ $agendamento->status }}</td>
                <td>
                    @if($agendamento->status == 'pendente')
                        <a href="{{ url('/admin/aprovar/'.$agendamento->id) }}" class="btn btn-success btn-sm">
                            Aprovar
                        </a>

                        <a href="{{ url('/admin/recusar/'.$agendamento->id) }}" class="btn btn-danger btn-sm">
                            Recusar
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>