@extends('adminlte::page')

@section('title', 'Relatórios')

@section('content_header')
<h1>Gestão de Relatórios</h1>
@stop

@section('content')
<div class="container-fluid">

    <div class="row">

        {{-- RELATÓRIO 1: Atendimentos por Período --}}
        <div class="col-md-6 mt-4">
            <div class="card card-success card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-calendar-alt mr-2"></i> Atendimentos por Período
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('relatorios.atendimentos.periodo')  }}" method="GET">
                        <div class="form-group">
                            <label for="periodo_inicio">Data Inicial:</label>
                            <input type="date" id="periodo_inicio" name="data_inicio" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="periodo_fim">Data Final:</label>
                            <input type="date" id="periodo_fim" name="data_fim" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success btn-block mt-3">
                            <i class="fas fa-file-alt mr-1"></i> Gerar Relatório
                        </button>
                    </form>
                    <p class="text-muted small mt-3 mb-0">
                        Gera um resumo consolidado dos atendimentos realizados em um intervalo de datas específico
                        (semanal, mensal ou anual).
                    </p>
                </div>
            </div>
        </div>

        {{-- RELATÓRIO 2: Atendimentos por Beneficiário --}}
        <div class="col-md-6 mt-4">
            <div class="card card-info card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-user-friends mr-2"></i> Atendimentos por Beneficiário
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('relatorios.atendimentos.beneficiario') }}" method="GET">
                        <div class="form-group">
                            <label for="beneficiario_id">Selecione o Beneficiário:</label>
                            <select id="beneficiario_id" name="beneficiario_id" class="form-control select2">
                                <option value="">-- Escolha --</option>
                                @foreach($beneficiarios as $b)
                                    <option value="{{ $b->id }}">{{ $b->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info btn-block mt-3">
                            <i class="fas fa-file-alt mr-1"></i> Gerar Relatório
                        </button>
                    </form>
                    <p class="text-muted small mt-3 mb-0">
                        Mostra todos os atendimentos realizados para o beneficiário selecionado, com datas,
                        profissionais e áreas.
                    </p>
                </div>
            </div>
        </div>

        {{-- RELATÓRIO 3: Distribuição de Cestas Básicas --}}
        <div class="col-md-6 mt-4">
            <div class="card card-warning card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-box mr-2"></i> Distribuição de Cestas Básicas
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('relatorios.cestas') }}" method="GET">
                        <div class="form-group">
                            <label for="beneficiario_cesta">Beneficiário:</label>
                            <select id="beneficiario_cesta" name="beneficiario_id" class="form-control select2">
                                <option value="">-- Escolha --</option>
                                @foreach($beneficiarios as $b)
                                    <option value="{{ $b->id }}">{{ $b->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cesta_inicio">Período Inicial:</label>
                            <input type="date" id="cesta_inicio" name="data_inicio" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="cesta_fim">Período Final:</label>
                            <input type="date" id="cesta_fim" name="data_fim" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-warning btn-block text-white mt-3">
                            <i class="fas fa-file-alt mr-1"></i> Gerar Relatório
                        </button>
                    </form>
                    <p class="text-muted small mt-3 mb-0">
                        Exibe todas as entregas de cestas básicas realizadas para o beneficiário no período selecionado.
                    </p>
                </div>
            </div>
        </div>

        {{-- RELATÓRIO 4: Resumo Anual --}}
        <div class="col-md-6 mt-4">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-chart-pie mr-2"></i> Resumo Anual
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('relatorios.anual') }}" method="GET">
                        <div class="form-group">
                            <label for="ano">Selecione o Ano:</label>
                            <select id="ano" name="ano" class="form-control">
                                @for ($i = now()->year; $i >= now()->year - 5; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-3">
                            <i class="fas fa-file-alt mr-1"></i> Gerar Relatório
                        </button>
                    </form>
                    <p class="text-muted small mt-3 mb-0">
                        Mostra o total consolidado de atendimentos e cestas básicas distribuídas ao longo do ano.
                    </p>
                </div>
            </div>
        </div>

        {{-- RELATÓRIO 5: Agendamentos Futuros --}}
        <div class="col-md-6 mt-4 d-none">
            <div class="card card-secondary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-calendar-check mr-2"></i> Agendamentos Futuros
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('relatorios.agendamentos') }}" method="GET">
                        <div class="form-group">
                            <label for="profissional_id">Profissional:</label>
                            <select id="profissional_id" name="profissional_id" class="form-control select2">
                                <option value="">-- Todos --</option>
                                @foreach($profissionais as $p)
                                    <option value="{{ $p->id }}">{{ $p->nome_completo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="agendamento_inicio">De:</label>
                            <input type="date" id="agendamento_inicio" name="inicio" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="agendamento_fim">Até:</label>
                            <input type="date" id="agendamento_fim" name="fim" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-secondary btn-block mt-3">
                            <i class="fas fa-file-alt mr-1"></i> Gerar Relatório
                        </button>
                    </form>
                    <p class="text-muted small mt-3 mb-0">
                        Lista todos os agendamentos futuros filtrando por profissional ou intervalo de datas.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@stop

@section('css')
<style>
    .card {
        transition: 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-title i {
        color: #28a745;
    }

    .form-group label {
        font-weight: 600;
    }

    .text-muted.small {
        font-size: 12px;
    }
</style>
@stop

@section('js')
<script>
    $(function () {
        console.log('Tela de relatórios carregada com sucesso');
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: 'Selecione uma opção'
        });
    });
</script>
@stop