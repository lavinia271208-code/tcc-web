@extends('layouts.app')

@section('content')
<div class="container" style="padding: 40px 0;">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: #e6b0a2; color: white;">
                    <strong>Adicionar Novo Serviço</strong>
                </div>
                <div class="card-body">
                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nome do Serviço</label>
                            <input type="text" name="nome" class="form-control" placeholder="Ex: Maquiagem de Noiva" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Preço (R$)</label>
                            <input type="number" name="preco" class="form-control" placeholder="0.00" step="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Duração (minutos)</label>
                            <input type="number" name="duracao" class="form-control" placeholder="Ex: 60" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descrição (Opcional)</label>
                            <textarea name="descricao" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn" style="background-color: #e6b0a2; color: white;">Cadastrar Serviço</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <strong>Serviços Ativos</strong>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-muted">
                                <th>Serviço</th>
                                <th>Preço</th>
                                <th>Tempo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Exemplo estático --}}
                            <tr>
                                <td>Maquiagem Social</td>
                                <td>R$ 150,00</td>
                                <td>60 min</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">Editar</button>
                                    <button class="btn btn-sm btn-outline-danger">Excluir</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection