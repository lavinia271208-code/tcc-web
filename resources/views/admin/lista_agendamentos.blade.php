@extends('layouts.app')

@section('content')
<div style="background-color: #FBF5F0; min-height: 100vh; padding: 40px 0;">

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 style="font-family: 'Playfair Display', serif;">Lista de Agendamentos</h2>
                <p class="text-muted mb-0">Agendamentos do dia de hoje ({{ \Carbon\Carbon::now()->format('d/m/Y') }}).</p>
            </div>

            <div class="d-flex gap-2">
                <button type="button" 
                        id="btnOpenCalendar"
                        class="btn" 
                        style="background-color:#e6b0a2; color:#000; font-weight:bold;">Ver Calendário</button>

                <a href="{{ route('admin.lista_agendamentos.create') }}"
                   class="btn"
                   style="background-color:#e6b0a2; color:#000; font-weight:bold;">+ Novo Agendamento</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr style="background-color: #e6b0a2;">
                            <th style="background-color: #e6b0a2; color: #000; font-weight: bold; border: none;" class="px-3">Cliente</th>
                            <th style="background-color: #e6b0a2; color: #000; font-weight: bold; border: none;">Serviço</th>
                            <th style="background-color: #e6b0a2; color: #000; font-weight: bold; border: none;">Data</th>
                            <th style="background-color: #e6b0a2; color: #000; font-weight: bold; border: none;">Horário</th>
                            <th style="background-color: #e6b0a2; color: #000; font-weight: bold; border: none;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($agendamentos as $agendamento)
                        <tr>
                            <td class="px-3">
                                {{ $agendamento->user->name ?? $agendamento->cliente_nome }}
                            </td>
                            <td>
                                {{ $agendamento->servico->nome }}
                            </td>
                            <td>
                                {{ $agendamento->data_hora->format('d/m/Y') }}
                            </td>
                            <td>
                                {{ $agendamento->data_hora->format('H:i') }}
                            </td>
                            <td>
                                <button type="button"
                                    class="btn btn-sm btn-outline-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $agendamento->id }}">
                                    Editar
                                </button>

                                <form action="{{ route('admin.lista_agendamentos.destroy', $agendamento->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Tem certeza que deseja excluir este agendamento?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>

                        <!-- modal -->
                        <div class="modal fade" id="editModal{{ $agendamento->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content border-0">
                                    <form action="{{ route('admin.lista_agendamentos.update', $agendamento->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header border-0" style="background-color:#e6b0a2; color:#000;">
                                            <h5 class="modal-title font-weight-bold">Editar Agendamento</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                        </div>

                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Nome do Cliente</label>
                                                <input type="text" name="cliente_nome" class="form-control"
                                                       value="{{ $agendamento->user->name ?? $agendamento->cliente_nome }}"
                                                       autocomplete="off" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label text-muted">Serviço</label>
                                                <select name="servico_id" class="form-select" required>
                                                    @foreach($servicos as $servico)
                                                        <option value="{{ $servico->id }}"
                                                            {{ $agendamento->servico_id == $servico->id ? 'selected' : '' }}>
                                                            {{ $servico->nome }}
                                                            - R$ {{ number_format($servico->preco, 2, ',', '.') }}
                                                            ({{ $servico->duracao_minutos }} min)
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label text-muted">Data e Hora</label>
                                                <input type="datetime-local" name="data_hora" class="form-control"
                                                       value="{{ $agendamento->data_hora->format('Y-m-d\TH:i') }}" required>
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
                            <td colspan="5" class="text-center py-4 text-muted">Nenhum agendamento para o dia de hoje.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <a href="{{ route('admin.dashboard') }}"
               class="btn"
               style="background-color:#e6b0a2; color:#000; font-weight:bold;">← Voltar ao Painel</a>
        </div>
    </div>
</div>

<div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header border-0" style="background-color: #e6b0a2;">
                <h5 class="modal-title text-dark font-weight-bold" id="calendarModalLabel">Calendário Geral de Agendamentos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var modalElement = document.getElementById('calendarModal');
    var btnOpen = document.getElementById('btnOpenCalendar');

    if (!modalElement || !calendarEl || !btnOpen) return;

    var calendarModal = new bootstrap.Modal(modalElement);

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: 'Hoje',
            month: 'Mês',
            week: 'Semana',
            day: 'Dia'
        },
        events: "{{ route('admin.agendamentos.events') }}",
        eventColor: '#e6b0a2',
        eventTextColor: '#000000'
    });

    btnOpen.addEventListener('click', function() {
        calendarModal.show();
    });

    modalElement.addEventListener('shown.bs.modal', function () {
        calendar.updateSize();
        calendar.render();
    });
});
</script>

<style>
    .fc-button-primary {
        background-color: #e6b0a2 !important;
        border-color: #e6b0a2 !important;
        color: #000 !important;
        font-weight: bold !important;
    }
    .fc-button-primary:hover {
        background-color: #d89c8e !important;
        border-color: #d89c8e !important;
    }
</style>
@endsection