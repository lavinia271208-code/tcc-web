@extends('layouts.app')

@section('content')
<div style="background-color: #FBF5F0; min-height: 100vh; padding: 40px 0;">
    <div class="container d-flex flex-column align-items-center">
        <div class="w-100" style="max-width: 650px;">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header border-0 py-3" style="background-color: #e6b0a2;">
                    <h3 class="mb-0 text-center text-dark font-weight-bold" style="font-family: 'Playfair Display', serif; font-size: 1.5rem;">Novo Agendamento</h3>
                </div>

                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.lista_agendamentos.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="cliente_nome" class="form-label text-muted">Nome do Cliente</label>
                            <input type="text" class="form-control" name="cliente_nome" id="cliente_nome" placeholder="Digite o nome do cliente" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="servico_id" class="form-label text-muted">Serviço</label>
                            <select class="form-select" name="servico_id" id="servico_id" required>
                                <option value="">Selecione um serviço</option>
                                @foreach($servicos as $servico)
                                    <option value="{{ $servico->id }}">
                                        {{ $servico->nome }}
                                        - R$ {{ number_format($servico->preco, 2, ',', '.') }}
                                        ({{ $servico->duracao_minutos }} min)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="data_hora" class="form-label text-muted">Data e Hora</label>
                            <input type="datetime-local" class="form-control" id="data_hora" name="data_hora" required>
                        </div>
                        <div class="d-flex justify-content-end pt-2">
                            <button type="submit" class="btn" style="background-color:#e6b0a2; color:#000; font-weight:bold;">Salvar Agendamento</button>
                        </div>
                    </form>
                </div>
            </div>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn" style="background-color:#e6b0a2; color:#000; font-weight:bold;">← Voltar ao Painel</a>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control,
    .form-select {
        font-family: inherit;
        color: #212529;
    }
    .form-control:focus, .form-select:focus {
        box-shadow: none;
        border-color: #e6b0a2;
    }
    .form-control::placeholder {
        color: #212529;
        font-family: inherit;
        font-style: normal;
        opacity: 1;
    }
</style>
@endsection