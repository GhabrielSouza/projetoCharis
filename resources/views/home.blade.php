@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Beneficiários Cadastrados</span>
                <span class="info-box-number">
                    {{ $beneficiariosCount }}
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-tie"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Profissionais Cadastrados</span>
                <span class="info-box-number">{{ $profissionaisCount }}</span>
            </div>
        </div>
    </div>

    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-basket"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Cestas Entregues</span>
                <span class="info-box-number">{{ $cestasCount }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-clock"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Atendimentos Realizados</span>
                <span class="info-box-number">{{ $atendimentosCount }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Beneficiarios cadastrados</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: block;">
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>
                <canvas id="beneficiariosDonutChart"
                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 550px;"
                    width="1100" height="500" class="chartjs-render-monitor"></canvas>
            </div>
        </div>

    </div>
    <div class="col-12 col-md-6">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Profissionais cadastrados</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            @if (empty($profissionaisPorArea))
                <div class="alert alert-info m-3">
                    <i class="fas fa-info-circle"></i>
                    Nenhum profissional cadastrado para exibir o gráfico.
                </div>
            @else
                <div class="card-body" style="display: block;">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <canvas id="profissionaisDonutChart"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 550px;"
                        width="1100" height="500" class="chartjs-render-monitor"></canvas>
                </div>
            @endif
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Cestas entregues por mes</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            @if(empty($cestasPorMes))
                <div class="alert alert-info m-3">
                    <i class="fas fa-info-circle"></i>
                    Nenhuma cesta entregue neste ano para exibir o gráfico.
                </div>
            @else
                <div class="card-body" style="display: block;">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <canvas id="cestasBarChart"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 550px;"
                        width="1100" height="500" class="chartjs-render-monitor"></canvas>
                </div>
            @endif
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Atendimentos realizados por mes</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            @if (empty($atendimentosPorMes))
                <div class="alert alert-info m-3">
                    <i class="fas fa-info-circle"></i>
                    Nenhum atendimento registrado neste ano para exibir o gráfico.
                </div>
            @else
                <div class="card-body" style="display: block;">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <canvas id="atendimentosBarChart"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 550px;"
                        width="1100" height="500" class="chartjs-render-monitor"></canvas>
                </div>
            @endif
        </div>
    </div>
</div>
@stop

@section('js')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        // Pass PHP variables to JS
        var profissionaisPorArea = @json(array_values($profissionaisPorArea));
        var profissionaisLabels = @json(array_keys($profissionaisPorArea));
        var cestasPorMes = @json(array_values($cestasPorMes));
        var atendimentosPorMes = @json(array_values($atendimentosPorMes));
        var beneficiariosLabels = @json(array_keys($beneficiariosPorSexo));
        var beneficiariosPorSexo = @json(array_values($beneficiariosPorSexo));

        // Beneficiários cadastrados (Donut)
        var ctxBeneficiarios = document.getElementById('beneficiariosDonutChart');
        if (ctxBeneficiarios) {
            new Chart(ctxBeneficiarios, {
                type: 'doughnut',
                data: {
                    labels: beneficiariosLabels,
                    datasets: [{
                        data: beneficiariosPorSexo,
                        backgroundColor: ['#007bff', '#dc3545', '#ffc107'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }

        // Profissionais cadastrados (Donut)
        var ctxProfissionais = document.getElementById('profissionaisDonutChart');
        if (ctxProfissionais && profissionaisPorArea.length > 0) {
            new Chart(ctxProfissionais, {
                type: 'doughnut',
                data: {
                    labels: profissionaisLabels,
                    datasets: [{
                        data: profissionaisPorArea,
                        backgroundColor: [
                            '#28a745', '#17a2b8', '#ffc107', '#6f42c1', '#007bff', '#dc3545', '#fd7e14'
                        ].slice(0, profissionaisPorArea.length),
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }

        // Cestas entregues por mês (Bar)
        var ctxCestas = document.getElementById('cestasBarChart');
        if (ctxCestas && cestasPorMes.length > 0) {
            new Chart(ctxCestas, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                    datasets: [{
                        label: 'Cestas Entregues',
                        data: cestasPorMes,
                        backgroundColor: '#28a745',
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        // Atendimentos realizados por mês (Bar)
        var ctxAtendimentos = document.getElementById('atendimentosBarChart');
        if (ctxAtendimentos && atendimentosPorMes.length > 0) {
            new Chart(ctxAtendimentos, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                    datasets: [{
                        label: 'Atendimentos',
                        data: atendimentosPorMes,
                        backgroundColor: '#ffc107',
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }
    </script>
@endsection