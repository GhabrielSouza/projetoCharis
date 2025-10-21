@extends('adminlte::page')

@section('title', 'Profissional')

@section('content_header')
<h1>Perfil do Profissional</h1>
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
                                <p><strong>Nome Completo:</strong><br>{{ $profissional->nome_completo }}</p>

                                <p><strong>Telefone:</strong><br>{{ $profissional->telefone ?? 'Não informado' }}</p>
                                <p><strong>Data de Nascimento:</strong><br>
                                    {{ \Carbon\Carbon::parse($profissional->data_nascimento)->format('d/m/Y') }}</p>

                            </div>
                            <div class="col-md-6">
                                <p><strong>Email:</strong><br>{{ $profissional->email ?? 'Não informado' }}</p>

                                <p><strong>CPF:</strong><br>{{ $profissional->cpf ?? 'Não informado' }}</p>
                                <p><strong>Área de Atuação:</strong><br>
                                    @if($profissional->areaAtuacao)
                                        {{ $profissional->areaAtuacao->nome_area }}
                                    @else
                                        Não informado
                                    @endif
                                </p>
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
                                            class="info-box-number">{{ $profissional->atendimentosRealizados->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-gradient-secondary">
                                    <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Último Atendimento</span>
                                        <span class="info-box-number">
                                            @if($profissional->atendimentosRealizados->last())
                                                {{ Carbon\Carbon::parse($profissional->atendimentosRealizados->last()->data)->format('d/m/Y') }}
                                            @else
                                                N/A
                                            @endif
                                        </span>
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
                                        <span class="info-box-number">{{ $profissional->agendamentos->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Agenda
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($profissional->agendamentos->isEmpty())
                            <div class="alert alert-info">
                                Nenhum agendamento registrado para este profissional.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Hora</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($profissional->agendamentos as $agendamento)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($agendamento->data_hora_agendamento)->format('d/m/Y') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($agendamento->hora_registro)->format('H:i') }}</td>
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