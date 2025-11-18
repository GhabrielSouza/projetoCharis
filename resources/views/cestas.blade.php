@extends('adminlte::page')

@section('title', 'Cestas Básicas Entregues')

@section('content_header')
<h1>Gestão de Cestas Básicas Entregues</h1>
@stop

@section('content')
<div class="container-fluid">
    <!-- Estatísticas -->
    <div class="row mb-4">
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
                                    <span class="info-box-text">Quantidade de Cestas entregues</span>
                                    <span class="info-box-number">{{ $cestasEntregues }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Tabela de Cestas entregues -->
        <div class="col-md-12 mt-4">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-shopping-basket mr-2"></i>
                        Cestas Básicas Entregues
                    </h3>
                    <div class="card-tools">
                        <button data-toggle="modal" data-target="#addAtendimentoModal" disabled
                            class="btn btn-sm btn-primary">
                            <i class="fas fa-plus mr-1"></i> Nova Cesta
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="cestasTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Beneficiário</th>
                                    <th>Data de Entrega</th>
                                    <th>Quantidade</th>
                                    <th>Observações</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cestas as $cesta)
                                    <tr>
                                        <td>{{ $cesta->beneficiario->nome }}</td>
                                        <td>{{ \Carbon\Carbon::parse($cesta->data_entrega)->format('d/m/Y') }}</td>
                                        <td>{{ $cesta->quantidade }}</td>
                                        <td>{{ $cesta->observacoes ? $cesta->observacoes : 'Sem observações' }}</td>
                                        <td>
                                            <div class="btn-group">

                                                <button type="button" class="btn btn-sm btn-warning" title="Editar"
                                                    data-toggle="modal" data-target="#editCestaModal-{{ $cesta->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('cesta.destroy', $cesta->id) }}" method="POST"
                                                    class="d-inline" name="formDeleteCesta{{ $cesta->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                                        <i class="fas fa-trash"></i>
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
    </div>

    @foreach($cestas as $cesta)
        <div class="modal fade" id="editCestaModal-{{ $cesta->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editCestaModalLabel-{{ $cesta->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                @include('modal._form_edicao_cesta_basica', ['cesta' => $cesta, 'beneficiario' => $cesta->beneficiario])
            </div>
        </div>
    @endforeach


</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
<!-- DataTables Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
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
    <!-- DataTables Buttons JS e dependências -->
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function () {

            // Tabela de Cestas entregues
            $('#cestasTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                },
                "order": [[0, "asc"], [1, "asc"]],
                "pageLength": 10,
                "lengthChange": false,
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
    </script>
@endsection