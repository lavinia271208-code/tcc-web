@extends('layouts.app')

@section('content')
<div style="background-color: #FBF5F0; min-height: 100vh; padding: 40px 0;">
    <div class="container">
        <div class="mb-4">
            <h2 style="font-family: 'Playfair Display', serif;">Bloqueio de Horários</h2>
            <p class="text-muted mb-0">Bloqueie datas e horários para evitar agendamentos.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header border-0 py-3" style="background-color: #e6b0a2;">
                <h5 class="mb-0 text-dark font-weight-bold" style="font-size: 1.1rem;">Bloquear Novo Horário</h5>
            </div>
            <div class="card-body py-4">
                <form action="{{ route('admin.bloqueios.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="data_hora_inicio" class="form-label text-muted">Início do Bloqueio</label>
                            <input type="datetime-local" class="form-control" name="data_hora_inicio" id="data_hora_inicio" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="data_hora_fim" class="form-label text-muted">Fim do Bloqueio</label>
                            <input type="datetime-local" class="form-control" name="data_hora_fim" id="data_hora_fim" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="motivo" class="form-label text-muted">Motivo (Opcional)</label>
                            <input type="text" class="form-control" name="motivo" id="motivo" placeholder="Ex: Almoço, Intervalo, Manutenção">
                        </div>
                    </div>

                    <button type="submit" class="btn" style="background-color: #e6b0a2; color: #000; font-weight: bold;">Salvar Bloqueio</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr style="background-color: #e6b0a2;">
                            <th style="background-color: #e6b0a2; color: #000; font-weight: bold; border: none;" class="px-3">Início</th>
                            <th style="background-color: #e6b0a2; color: #000; font-weight: bold; border: none;">Fim</th>
                            <th style="background-color: #e6b0a2; color: #000; font-weight: bold; border: none;">Motivo</th>
                            <th style="background-color: #e6b0a2; color: #000; font-weight: bold; border: none;" width="150">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bloqueios as $bloqueio)
                            <tr>
                                <td class="px-3">{{ $bloqueio->data_hora_inicio->format('d/m/Y H:i') }}</td>
                                <td>{{ $bloqueio->data_hora_fim->format('d/m/Y H:i') }}</td>
                                <td>{{ $bloqueio->motivo ?? 'Sem motivo informado' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button type="button"
                                            class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $bloqueio->id }}">
                                            Editar
                                        </button>

                                        <form action="{{ route('admin.bloqueios.destroy', $bloqueio->id) }}" method="POST" onsubmit="return confirm('Deseja realmente remover este bloqueio?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Desbloquear</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- modal  --> 
                            <div class="modal fade" id="editModal{{ $bloqueio->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content border-0">
                                        <form action="{{ route('admin.bloqueios.update', $bloqueio->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-header border-0" style="background-color:#e6b0a2; color:#000;">
                                                <h5 class="modal-title font-weight-bold">Editar Bloqueio</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                            </div>

                                            <div class="modal-body p-4">
                                                <div class="mb-3">
                                                    <label class="form-label text-muted">Início do Bloqueio</label>
                                                    <input type="datetime-local" name="data_hora_inicio" class="form-control"
                                                        value="{{ $bloqueio->data_hora_inicio->format('Y-m-d\TH:i') }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label text-muted">Fim do Bloqueio</label>
                                                    <input type="datetime-local" name="data_hora_fim" class="form-control"
                                                        value="{{ $bloqueio->data_hora_fim->format('Y-m-d\TH:i') }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label text-muted">Motivo (Opcional)</label>
                                                    <input type="text" name="motivo" class="form-control"
                                                        value="{{ $bloqueio->motivo }}"
                                                        placeholder="Ex: Almoço, Intervalo, Manutenção">
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
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Nenhum horário bloqueado no momento.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn" style="background-color:#e6b0a2; color:#000; font-weight:bold;">← Voltar ao Painela</a>
        </div>

    </div>
</div>
@endsection