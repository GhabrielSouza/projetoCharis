@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">CPU Traffic</span>
                <span class="info-box-number">
                    10
                    <small>%</small>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Likes</span>
                <span class="info-box-number">41,410</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Sales</span>
                <span class="info-box-number">760</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">New Members</span>
                <span class="info-box-number">2,000</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>

<div class="row">
    <div class="col-12 col-md-6">
        <div class="card card-danger">
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
                <canvas id="donutChart"
                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 550px;"
                    width="1100" height="500" class="chartjs-render-monitor"></canvas>
            </div>
        </div>

    </div>
    <div class="col-12 col-md-6">
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">Profissionais cadastrados</h3>

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
                <canvas id="donutChart"
                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 550px;"
                    width="1100" height="500" class="chartjs-render-monitor"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">Cestas entregues por mes</h3>

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
                <canvas id="barChart"
                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 550px;"
                    width="1100" height="500" class="chartjs-render-monitor"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">Atendimentos realizados por mes</h3>

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
                <canvas id="BarChart"
                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 550px;"
                    width="1100" height="500" class="chartjs-render-monitor"></canvas>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        // Beneficiários cadastrados (Donut)
        var ctxBeneficiarios = document.getElementById('donutChart');
        if (ctxBeneficiarios) {
            new Chart(ctxBeneficiarios, {
                type: 'doughnut',
                data: {
                    labels: ['Homens', 'Mulheres', 'Outros'],
                    datasets: [{
                        data: [120, 180, 10],
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
        var ctxProfissionais = document.querySelectorAll('#donutChart')[1];
        if (ctxProfissionais) {
            new Chart(ctxProfissionais, {
                type: 'doughnut',
                data: {
                    labels: ['Médicos', 'Enfermeiros', 'Psicólogos', 'Assistentes Sociais'],
                    datasets: [{
                        data: [15, 20, 8, 5],
                        backgroundColor: ['#28a745', '#17a2b8', '#ffc107', '#6f42c1'],
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
        var ctxCestas = document.getElementById('barChart');
        if (ctxCestas) {
            new Chart(ctxCestas, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                    datasets: [{
                        label: 'Cestas Entregues',
                        data: [30, 25, 40, 35, 50, 45, 60, 55, 70, 65, 80, 75],
                        backgroundColor: '#dc3545',
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
        var ctxAtendimentos = document.getElementById('BarChart');
        if (ctxAtendimentos) {
            new Chart(ctxAtendimentos, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                    datasets: [{
                        label: 'Atendimentos',
                        data: [50, 60, 55, 70, 65, 80, 75, 90, 85, 100, 95, 110],
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
    </script>
@endsection