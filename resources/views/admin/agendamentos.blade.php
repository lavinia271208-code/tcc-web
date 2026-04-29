@extends('layouts.app')

@section('content')
<div class="container" style="padding: 40px 0;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center mb-4" style="font-family: 'Playfair Display', serif;">Novo Agendamento</h2>
            
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="#" method="GET">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nome da Cliente</label>
                                <input type="text" class="form-control" placeholder="Digite o nome completo">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Serviço</label>
                                <select class="form-control">
                                    <option>Maquiagem Social</option>
                                    <option>Maquiagem Noiva</option>
                                    <option>Maquiagem Debutante</option>
                                    <option>Rabo de Cavalo</option>
                                    <option>Preso com Tiara</option>
                                    <option>Semi preso com Laço</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Data e Hora</label>
                                <input type="datetime-local" class="form-control">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Observações</label>
                            <textarea class="form-control" rows="3" placeholder="Ex: Alergias ou preferências de cores"></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn" style="background-color: #e6b0a2; color: white; font-weight: bold;">Salvar na Agenda</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('admin.dashboard') }}" style="color: #6c757d; text-decoration: none;">← Voltar ao Painel</a>
            </div>
        </div>
    </div>
</div>
@endsection