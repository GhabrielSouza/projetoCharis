@extends('adminlte::page')

@section('title', 'Profissional')

@section('content_header')
<h1>Cadastro de Profissional</h1>
@stop

@section('plugins.Datatables', true)

@section('content')
    <div class="card">
        <div class="card-header bg-orange text-white">
            <h3 class="card-title"><i class="fas fa-user-md mr-2"></i>Cadastro de Profissionais</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Recolher">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize" title="Expandir">
                    <i class="fas fa-expand"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="btn-group">
                        <button class="btn btn-outline-primary" title="Adicionar profissional" data-toggle="modal"
                            data-target="#addProfessionalModal">
                            <i class="fas fa-user-plus mr-1"></i> Novo Profissional
                        </button>
                        <button class="btn btn-outline-secondary" title="Filtrar profissionais">
                            <i class="fas fa-filter mr-1"></i> Filtrar
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-success dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-file-export mr-1"></i> Exportar
                            </button>
                            <div class="dropdown-menu" id="exportDropdown">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="search" class="form-control"
                            placeholder="Buscar profissionais por nome, registro ou especialidade..."
                            id="professionalSearch">
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="professionalSearchBtn">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="professionalTable" class="table table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th><i class="fas fa-id-badge mr-1"></i>Registro</th>
                            <th><i class="fas fa-user-tie mr-1"></i>Nome</th>
                            <th><i class="fas fa-stethoscope mr-1"></i>Especialidade</th>
                            <th><i class="fas fa-phone mr-1"></i>Contato</th>
                            <th><i class="fas fa-calendar-alt mr-1"></i>Cadastro</th>
                            <th><i class="fas fa-shield-alt mr-1"></i>Perfil</th>
                            <th><i class="fas fa-circle mr-1"></i>Status</th>
                            <th class="text-center"><i class="fas fa-tasks mr-1"></i>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>CRM/SP 123456</td>
                            <td>Dra. Ana Claudia Mendes</td>
                            <td>Cardiologia</td>
                            <td>(11) 98765-4321</td>
                            <td>15/03/2021</td>
                            <td><span class="badge badge-info">Médico</span></td>
                            <td><span class="badge badge-success">Ativo</span></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-info" title="Ver perfil completo">
                                        <i class="fas fa-id-card"></i>
                                    </button>
                                    <button data-toggle="modal" data-target="#addProfessionalModal" class="btn btn-warning"
                                        title="Editar cadastro">
                                        <i class="fas fa-user-edit"></i>
                                    </button>
                                    <button class="btn btn-secondary" title="Agendar">
                                        <i class="fas fa-calendar-plus"></i>
                                    </button>
                                    <button class="btn btn-danger" title="Desativar">
                                        <i class="fas fa-user-slash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Coren/SP 654321</td>
                            <td>Enf. Roberto Almeida</td>
                            <td>Enfermagem Geral</td>
                            <td>(11) 91234-5678</td>
                            <td>22/05/2022</td>
                            <td><span class="badge badge-primary">Enfermeiro</span></td>
                            <td><span class="badge badge-success">Ativo</span></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-info" title="Ver perfil completo">
                                        <i class="fas fa-id-card"></i>
                                    </button>
                                    <button class="btn btn-warning" title="Editar cadastro">
                                        <i class="fas fa-user-edit"></i>
                                    </button>
                                    <button class="btn btn-secondary" title="Agendar">
                                        <i class="fas fa-calendar-plus"></i>
                                    </button>
                                    <button class="btn btn-danger" title="Desativar">
                                        <i class="fas fa-user-slash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>CRP/SP 789012</td>
                            <td>Psic. Juliana Santos</td>
                            <td>Psicologia Clínica</td>
                            <td>(11) 99876-5432</td>
                            <td>10/01/2023</td>
                            <td><span class="badge badge-purple">Psicólogo</span></td>
                            <td><span class="badge badge-warning">Férias</span></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-info" title="Ver perfil completo">
                                        <i class="fas fa-id-card"></i>
                                    </button>
                                    <button class="btn btn-warning" title="Editar cadastro">
                                        <i class="fas fa-user-edit"></i>
                                    </button>
                                    <button class="btn btn-secondary" title="Agendar">
                                        <i class="fas fa-calendar-plus"></i>
                                    </button>
                                    <button class="btn btn-success" title="Reativar">
                                        <i class="fas fa-user-check"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="dataTables_info">
                        Mostrando <strong>1</strong> a <strong>3</strong> de <strong>47</strong> profissionais
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class="pagination pagination-sm justify-content-end">
                        <li class="page-item disabled">
                            <a class="page-link" href="#"><i class="fas fa-angle-double-left"></i></a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#"><i class="fas fa-angle-double-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer text-muted small">
            <div class="row">
                <div class="col-md-6">
                    <i class="fas fa-sync-alt mr-1"></i> Atualizado em: 02/06/2023 às 14:30
                </div>
                <div class="col-md-6 text-right">
                    <span class="mr-3">Ativos: <strong>42</strong></span>
                    <span class="mr-3">Férias: <strong>3</strong></span>
                    <span>Inativos: <strong>2</strong></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Cadastro/Edição de Profissionais -->
    <div class="modal fade" id="addProfessionalModal" tabindex="-1" role="dialog" aria-labelledby="addProfessionalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="professionalForm">
                @csrf
                <input type="hidden" name="id" id="profissionalId">
                <div class="modal-content">
                    <div class="modal-header bg-orange text-white">
                        <h5 class="modal-title" id="addProfessionalLabel"><i class="fas fa-user-md mr-2"></i>Cadastro de
                            Profissional</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label><i class="fas fa-user mr-1"></i>Nome Completo</label>
                                <input type="text" class="form-control" name="nome" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label><i class="fas fa-calendar-alt mr-1"></i>Data de Nascimento</label>
                                <input type="date" class="form-control" name="nascimento" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label><i class="fas fa-id-card mr-1"></i>CPF</label>
                                <input type="text" class="form-control cpf-mask" name="cpf" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label><i class="fas fa-phone mr-1"></i>Telefone</label>
                                <input type="text" class="form-control phone-mask" name="telefone" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label><i class="fas fa-envelope mr-1"></i>Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label><i class="fas fa-stethoscope mr-1"></i>Área de Atuação</label>
                                <input type="text" class="form-control" name="area" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label><i class="fas fa-id-badge mr-1"></i>Número de Registro</label>
                                <input type="text" class="form-control" name="registro" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label><i class="fas fa-user-tag mr-1"></i>Perfil</label>
                                <select name="perfil" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    <option>Médico</option>
                                    <option>Enfermeiro</option>
                                    <option>Psicólogo</option>
                                    <option>Assistente Social</option>
                                    <option>Outro</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-comment-dots mr-1"></i>Observações</label>
                            <textarea class="form-control" name="observacoes" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-1"></i>Salvar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

            // ---- LÓGICA DO FORMULÁRIO (que estava sendo ignorada) ----
            $('#professionalForm').on('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Salvar profissional?',
                    text: 'Deseja realmente salvar este cadastro?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, salvar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Salvando...',
                            html: 'Aguarde enquanto o cadastro é realizado.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        const form = $('#professionalForm');
                        const formData = form.serialize();

                        $.ajax({
                            url: '{{ route('profissionais.store') }}',
                            type: 'POST',
                            data: formData,
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sucesso!',
                                    text: 'Cadastro realizado com sucesso.',
                                    timer: 2500,
                                    showConfirmButton: false
                                });
                                $('#addProfessionalModal').modal('hide');
                                form.trigger('reset');
                                location.reload();
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro ao salvar',
                                    text: xhr.responseJSON?.message || 'Ocorreu um erro ao salvar o profissional.',
                                });
                            }
                        });
                    }
                });
            });


            // ---- LÓGICA DO DATATABLES ----
            const table = $('#professionalTable').DataTable({
                dom: 'frtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Profissionais',
                        text: '<i class="fas fa-file-excel mr-1"></i> Excel',
                        className: 'dropdown-item'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Profissionais',
                        text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                        className: 'dropdown-item',
                        orientation: 'landscape',
                        pageSize: 'A4'
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Profissionais',
                        text: '<i class="fas fa-file-csv mr-1"></i> CSV',
                        className: 'dropdown-item'
                    },
                    {
                        extend: 'print',
                        title: 'Profissionais',
                        text: '<i class="fas fa-print mr-1"></i> Imprimir',
                        className: 'dropdown-item'
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
                },
                paging: true,
                searching: true,
                ordering: true,
                responsive: true
            });

            table.buttons().container().appendTo('#exportDropdown');
        });
    </script>
@endsection