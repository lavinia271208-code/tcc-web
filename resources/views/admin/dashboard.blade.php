@extends('layouts.app')

@section('content')
<div class="container" style="padding: 30px;">
    <h2 style="font-family: 'Playfair Display', serif;">Bem-vinda, Administradora!</h2>
    <p class="text-muted">Aqui está o resumo do seu estúdio hoje.</p>
    <hr>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white shadow-sm" style="background-color: #e6b0a2; border: none;">
                <div class="card-body">
                    <h6>Agendamentos Hoje</h6>
                    <h3>5</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark text-white shadow-sm" style="border: none;">
                <div class="card-body">
                    <h6>Pendentes de Confirmação</h6>
                    <h3>2</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><strong>Próximas Clientes</strong></div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <thead>
                            <tr class="text-muted">
                                <th>Hora</th>
                                <th>Cliente</th>
                                <th>Serviço</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>14:00</td>
                                <td>Alice Oliveira</td>
                                <td>Penteado</td>
                            </tr>
                            <tr>
                                <td>15:30</td>
                                <td>Beatriz Souza</td>
                                <td>Maquiagem + Cabelo</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><strong>Ações Rápidas</strong></div>
                <div class="card-body d-grid gap-2">
                    <a href="{{ route('admin.agendamentos') }}" class="btn btn-outline-secondary">
                        Novo Agendamento
                    </a>
                    <a href="{{ route('admin.servicos') }}" class="btn btn-outline-secondary">
                        Cadastrar Serviço
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection