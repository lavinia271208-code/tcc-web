@extends('layouts.app')

@section('content')
<div style="background-color: #FBF5F0; min-height: 100vh; padding: 40px 0;">
    <div class="container">
        <div class="mb-4">
            <h2 style="font-family: 'Playfair Display', serif;">Gestão de Serviços</h2>
            <p class="text-muted mb-0">Cadastre e gerencie os serviços do seu estúdio.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row mb-4">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <div class="card shadow-sm border-0">
                    <div class="card-header border-0 py-3" style="background-color:#e6b0a2; color:#000;">
                        <h5 class="mb-0 font-weight-bold" style="font-size: 1.1rem;">Adicionar Novo Serviço</h5>
                    </div>
                    <div class="card-body p-4">

                        @if ($errors->any() && !session('editing'))
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.servicos.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label text-muted">Nome do Serviço</label>
                                <input type="text" name="nome" class="form-control" placeholder="Ex: Maquiagem de Noiva" value="{{ old('nome') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Preço (R$)</label>
                                <input type="text" name="preco" id="preco" class="form-control" inputmode="decimal" placeholder="0,00" value="{{ old('preco') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Duração (minutos)</label>
                                <input type="text" name="duracao" id="duracao" class="form-control" inputmode="numeric" placeholder="Ex: 60" value="{{ old('duracao') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Descrição</label>
                                <textarea name="descricao" class="form-control" rows="3" style="resize: none;">{{ old('descricao') }}</textarea>
                            </div>

                            <button type="submit" class="btn w-100" style="background-color:#e6b0a2; color:#000; font-weight:bold;">Cadastrar Serviço</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header border-0 py-3" style="background-color:#e6b0a2; color:#000;">
                        <h5 class="mb-0 font-weight-bold" style="font-size: 1.1rem;">Serviços Ativos</h5>
                    </div>
                    <div class="card-body p-0">

                        @if ($servicos->isEmpty())
                            <p class="text-muted p-4 mb-0">Nenhum serviço cadastrado ainda.</p>
                        @else
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr style="background-color: #e6b0a2;">
                                        <th style="background-color: #e6b0a2; color: #000; font-weight: bold; border: none;" class="px-3">Serviço</th>
                                        <th style="background-color: #e6b0a2; color: #000; font-weight: bold; border: none;">Preço</th>
                                        <th style="background-color: #e6b0a2; color: #000; font-weight: bold; border: none;">Tempo</th>
                                        <th style="background-color: #e6b0a2; color: #000; font-weight: bold; border: none;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($servicos as $servico)
                                        <tr>
                                            <td class="px-3">{{ $servico->nome }}</td>
                                            <td>R$ {{ number_format($servico->preco, 2, ',', '.') }}</td>
                                            <td>{{ $servico->duracao_minutos }} min</td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $servico->id }}">Editar</button>

                                                <form action="{{ route('admin.servicos.destroy', $servico->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este serviço?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="editModal{{ $servico->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content border-0">
                                                    <form action="{{ route('admin.servicos.update', $servico->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="modal-header border-0" style="background-color:#e6b0a2; color:#000;">
                                                            <h5 class="modal-title font-weight-bold">Editar Serviço</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                                        </div>

                                                        <div class="modal-body p-4">
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Nome do Serviço</label>
                                                                <input type="text" name="nome" class="form-control" value="{{ $servico->nome }}" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Preço (R$)</label>
                                                                <input type="text" name="preco" class="form-control" inputmode="decimal" value="{{ $servico->preco }}" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Duração (minutos)</label>
                                                                <input type="text" name="duracao" class="form-control" inputmode="numeric" value="{{ $servico->duracao_minutos }}" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Descrição</label>
                                                                <textarea name="descricao" class="form-control" rows="3" style="resize: none;">{{ $servico->descricao }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer border-0">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn" style="background-color:#e6b0a2; color:#000; font-weight:bold;">Salvar Alterações</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                    </div>
                </div>

                <div>
                    <a href="{{ route('admin.dashboard') }}" class="btn" style="background-color:#e6b0a2; color:#000; font-weight:bold;">← Voltar ao Painel</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        box-shadow: none;
        border-color: #e6b0a2;
    }
</style>
@endsection