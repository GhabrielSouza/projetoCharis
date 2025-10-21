@extends('adminlte::page')

@section('title', 'Perfil do Beneficiário')

@section('content_header')
<h1>Perfil do Beneficiário</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Dados Pessoais -->
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user mr-2"></i>
                            Dados Pessoais
                        </h3>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nome Completo:</strong><br>{{ $beneficiario->nome }}</p>
                                <p><strong>Data de
                                        Nascimento:</strong><br>{{ $beneficiario->data_nascimento->format('d/m/Y') }}</p>
                                <p><strong>Telefone:</strong><br>{{ $beneficiario->telefone ?? 'Não informado' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Endereço:</strong><br>{{ $beneficiario->endereco_logradouro}},
                                    {{ $beneficiario->endereco_numero ?? '' }},
                                    {{ $beneficiario->endereco_bairro ?? '' }}
                                </p>
                                <p><strong>CEP:</strong><br>{{ $beneficiario->cep ?? 'Não informado' }}</p>
                                </p>
                                @if(isset($beneficiario->cidade))
                                    <p><strong>Cidade:</strong><br>{{ $beneficiario->cidade->nome }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estatísticas -->
            <div class="col-md-6">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-2"></i>
                            Estatísticas
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box bg-gradient-success">
                                    <span class="info-box-icon"><i class="fas fa-calendar-check"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Atendimentos</span>
                                        <span
                                            class="info-box-number">{{ $beneficiario->atendimentosRealizados->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-gradient-warning">
                                    <span class="info-box-icon"><i class="fas fa-shopping-basket"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Cestas Básicas</span>
                                        <span
                                            class="info-box-number">{{ $beneficiario->cestasBasicasEntregues->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="info-box bg-gradient-primary">
                                    <span class="info-box-icon"><i class="fas fa-calendar-alt"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Agendamentos</span>
                                        <span class="info-box-number">{{ $beneficiario->agendamentos->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-gradient-secondary">
                                    <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Último Atendimento</span>
                                        <span class="info-box-number">
                                            @if($beneficiario->atendimentosRealizados->last())
                                                {{ Carbon\Carbon::parse($beneficiario->atendimentosRealizados->last()->data_hora_atendimento)->format('d/m/Y') }}
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Histórico de Atendimentos -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-history mr-2"></i>
                            Histórico de Atendimentos
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        @if($beneficiario->atendimentosRealizados->isEmpty())
                            <div class="alert alert-info m-3">
                                Nenhum atendimento registrado para este beneficiário.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Profissional</th>
                                            <th>Área de atendimento</th>
                                            <th>Descrição</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($beneficiario->atendimentosRealizados->sortByDesc('data') as $atendimento)
                                            <tr>
                                                <td>{{ Carbon\Carbon::parse($atendimento->data_hora_atendimento)->format('d/m/Y') }}
                                                </td>
                                                <td>{{ $atendimento->profissional_id ?? 'N/A' }}</td>
                                                <td>{{ $atendimento->area_atendimento_id ?? 'N/A' }}</td>
                                                <td>{{ Str::limit($atendimento->descricao_atendimento, 100) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Cestas Básicas -->
        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-shopping-basket mr-2"></i>
                            Cestas Básicas Recebidas
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        @if($beneficiario->cestasBasicasEntregues->isEmpty())
                            <div class="alert alert-info m-3">
                                Nenhuma cesta básica registrada para este beneficiário.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Quantidade</th>
                                            <th>Observações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($beneficiario->cestasBasicasEntregues->sortByDesc('data_entrega') as $cesta)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($cesta->data_entrega)->format('d/m/Y') }}</td>
                                                <td>{{ $cesta->quantidade }}</td>
                                                <td>{{ $cesta->observacoes ? Str::limit($cesta->observacoes, 50) : 'Nada a informar' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Próximos Agendamentos -->
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Próximos Agendamentos
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        @if($beneficiario->agendamentos->where('data_hora_agendamento', '>=', now())->isEmpty())
                            <div class="alert alert-info m-3">
                                Nenhum agendamento futuro para este beneficiário.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Hora</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($beneficiario->agendamentos->where('data_hora_agendamento', '>=', now())->sortBy('data_hora_agendamento') as $agendamento)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($agendamento->data_hora_agendamento)->format('d/m/Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($agendamento->hora_registro)->format('H:i') }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $agendamento->status_agendamento == 'confirmado' ? 'success' : ($agendamento->status_agendamento == 'pendente' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($agendamento->status_agendamento) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<style>
    .info-box {
        cursor: default;
        min-height: 80px;
    }

    .info-box-icon {
        font-size: 1.8rem;
    }

    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, .125);
    }
</style>
@stop

@section('js')
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@stop
