@extends('adminlte::page')

@section('title', 'Atendimentos e Agendamentos')

@section('content_header')
<h1>Gestão de Atendimentos e Agendamentos</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Tabela de Agendamentos Pendentes -->
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Agendamentos Pendentes
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="agendamentosTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Data</th>
                                    <th>Hora</th>
                                    <th>Paciente</th>
                                    <th>Telefone</th>
                                    <th>Status</th>
                                    <th>Agendamento</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($agendamentosPendentes as $agendamento)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($agendamento->data_hora_agendamento)->format('d/m/Y') }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($agendamento->hora_registro)->format('H:i') }}
                                        </td>
                                        <td>{{ $agendamento->beneficiario->nome }}</td>
                                        <td>{{ $agendamento->beneficiario->telefone }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $agendamento->status_agendamento == 'pendente' ? 'warning' : ($agendamento->status_agendamento == 'realizado' ? 'success' : 'danger') }}">
                                                {{ ucfirst($agendamento->status_agendamento) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $agendamento->agendamento }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group ">
                                                @if($agendamento->status_agendamento == 'pendente')
                                                    <form action="{{ route('agendamento.confirmar', $agendamento->id) }}"
                                                        method="POST" class="d-inline" name="formConfirmAtendimento">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success"
                                                            title="Confirmar Atendimento">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                <form action="{{ route('agendamento.cancelar', $agendamento->id) }}"
                                                    method="POST" class="d-inline px-1" name="formCancelAgendamento">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        title="Cancelar Agendamento">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>

                                                <!-- botao para gerar prontuario em pdf -->
                                                <form action="{{ route('agendamento.prontuario', $agendamento->id) }}"
                                                    method="GET" class="d-inline">
                                                    <button class="btn btn-sm btn-info" title="Gerar Prontuário" onclick="">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela de Atendimentos Realizados -->
        <div class="col-md-12 mt-4">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-check mr-2"></i>
                        Atendimentos Realizados
                    </h3>
                    <div class="card-tools">
                        <button data-toggle="modal" data-target="#addAtendimentoModal" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus mr-1"></i> Novo Atendimento
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="atendimentosTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Data</th>
                                    <th>Hora</th>
                                    <th>Paciente</th>

                                    <th>Observações</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($atendimentos as $atendimento)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($atendimento->data_hora_atendimento)->format('d/m/Y') }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($atendimento->hora_registro)->format('H:i') }}</td>
                                        <td>{{ $atendimento->beneficiario->nome }}</td>
                                        <td>{{ Str::limit($atendimento->descricao_atendimento, 50) }}</td>
                                        <td>

                                            <button type="button" class="btn btn-sm btn-warning" title="Editar"
                                                data-toggle="modal"
                                                data-target="#addAtendimentoModal-{{ $atendimento->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <form action="{{ route('atendimentos.destroy', $atendimento->id) }}"
                                                method="POST" class="d-inline px-1" name="formDeleteAtendimento">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @if ($atendimento->agendamento_origem_id)
                                                <form
                                                    action="{{ route('agendamento.prontuario', $atendimento->agendamento_origem_id) }}"
                                                    method="GET" class="d-inline">
                                                    <button class="btn btn-sm btn-info" title="Gerar Prontuário" onclick="">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </button>
                                                </form>
                                            @endif

                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modalAtendimento" id="addAtendimentoModal" tabindex="-1" role="dialog"
        aria-labelledby="addAtendimentoLabel" aria-hidden="true" name="modalAtendimento">
        <div class="modal-dialog modal-lg" role="document">
            @include('modal._form_cadastro_atendimento', ['beneficiarios' => $beneficiarios, 'profissionais' => $profissionais, 'areas', 'horariosDisponiveis'])
        </div>
    </div>

    @foreach($atendimentos as $atendimento)
        <div class="modal fade modalAtendimento" id="addAtendimentoModal-{{ $atendimento->id }}" tabindex="-1" role="dialog"
            aria-labelledby="addAtendimentoLabel" name="modalAtendimento" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                @include('modal._form_edicao_atendimento', ['atendimento' => $atendimento, 'beneficiarios' => $beneficiarios, 'profissionais' => $profissionais, 'areas' => $areas, 'horariosDisponiveis' => $horariosDisponiveis])
            </div>
        </div>
    @endforeach

    <!-- Estatísticas -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-2"></i>
                        Estatísticas
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="info-box bg-gradient-success">
                                <span class="info-box-icon"><i class="fas fa-calendar-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Atendimentos Hoje</span>
                                    <span class="info-box-number">{{ $atendimentosHoje }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="info-box bg-gradient-primary">
                                <span class="info-box-icon"><i class="fas fa-calendar-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Agendamentos Pendentes</span>
                                    <span class="info-box-number">{{ $totalAgendamentosPendentes }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="info-box bg-gradient-warning">
                                <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Atendimentos Semana</span>
                                    <span class="info-box-number">{{ $atendimentosSemana }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="info-box bg-gradient-danger">
                                <span class="info-box-icon"><i class="fas fa-times"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Cancelamentos</span>
                                    <span class="info-box-number">{{ $totalCancelamentos }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
<style>
    .table-responsive {
        overflow-x: auto;
    }

    .info-box {
        cursor: default;
        min-height: 80px;
    }

    .info-box-icon {
        font-size: 1.8rem;
    }

    .btn-group .btn {
        margin-right: 5px;
    }

    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>


    @if(session('success'))
        <script>
            Swal.fire({
                title: 'Sucesso!',
                icon: "success",
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            setTimeout(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'Entendi'
                });
            }, 500);
        </script>
    @endif

    <script>
        $(document).ready(function () {
            // Tabela de Atendimentos Realizados
            $('#atendimentosTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                },
                "order": [[0, "asc"], [1, "asc"]],
                "pageLength": 5,
                "lengthChange": true,
                "searching": true,
                "paging": true,
                "columnDefs": [
                    { "orderable": false, "targets": 4 }
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ]
            });

            // Tabela de Agendamentos Pendentes
            $('#agendamentosTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                },
                "order": [[0, "asc"], [1, "asc"]],
                "pageLength": 5,
                "lengthChange": true,
                "searching": true,
                "paging": true,
                "columnDefs": [
                    { "orderable": false, "targets": 6 }
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ]
            });

            // SweetAlert para exclusão
            $('form[name="formDeleteAtendimento"]').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Confirmação',
                    text: 'Tem certeza que deseja excluir este atendimento?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, excluir',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });

            // SweetAlert para confirmação
            $('form[name="formConfirmAtendimento"]').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Confirmação',
                    text: 'Tem certeza que deseja confirmar este atendimento?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, confirmar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });

            // SweetAlert para cancelamento
            $('form[name="formCancelAgendamento"]').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Confirmação',
                    text: 'Tem certeza que deseja cancelar este agendamento?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, cancelar',
                    cancelButtonText: 'Manter'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });

        $('.modalAtendimento').on('submit', function () {
            Swal.fire({
                title: 'Salvando...',
                text: 'Por favor, aguarde.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });

    </script>
@endsection