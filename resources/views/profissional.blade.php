@extends('adminlte::page')

@section('title', 'Profissional')

@section('content_header')
<h1>Cadastro de Profissional</h1>
@stop

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
                <div class="col-md-6 d-flex justify-content-end ">
                    <form action="{{ route('profissionais.index') }}" method="GET">
                        <div class="input-group">
                            <input type="search" class="form-control" name="search"
                                placeholder="Buscar por nome, registro ou especialidade..."
                                value="{{ request('search') ?? '' }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
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
                        @foreach ($profissionais as $profissional)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $profissional->numero_registro }}</td>
                                <td>{{ $profissional->nome_completo }}</td>
                                <td>
                                    @if($profissional->areaAtuacao)
                                        {{ $profissional->areaAtuacao->nome_area }}
                                    @else
                                        Não definida
                                    @endif
                                </td>
                                <td>{{ $profissional->telefone }}</td>
                                <td>{{ $profissional->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if($profissional->perfil == 'Médico')
                                        <span class="badge badge-info">Médico</span>
                                    @elseif($profissional->perfil == 'Enfermeiro')
                                        <span class="badge badge-success">Enfermeiro</span>
                                    @elseif($profissional->perfil == 'Psicologo')
                                        <span class="badge badge-info">Psicólogo</span>
                                    @elseif($profissional->perfil == 'Assistente Social')
                                        <span class="badge badge-warning">Assistente Social</span>
                                    @else
                                        <span class="badge badge-secondary">Outro</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($profissional->status == 'ativo')
                                        <span class="badge badge-success">Ativo</span>
                                    @elseif ($profissional->status == 'pendente')
                                        <span class="badge badge-warning">Pendente</span>
                                    @else
                                        <span class="badge badge-danger">Inativo</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-info" title="Ver perfil completo">
                                            <i class="fas fa-id-card"></i>
                                        </button>
                                        <button data-toggle="modal" data-target="#editProfessionalModal-{{ $profissional->id }}"
                                            class="btn btn-warning" title="Editar cadastro">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button class="btn btn-secondary" title="Agendar">
                                            <i class="fas fa-calendar-plus"></i>
                                        </button>
                                        <form action="{{ route('profissional.toggleStatus', $profissional->id) }}" method="POST"
                                            style="display: inline;" class="form-toggle-status">
                                            @csrf

                                            @if ($profissional->status == 'ativo')
                                                <button type="submit" class="btn btn-danger" title="Inativar beneficiário"
                                                    style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                                    <i class="fas fa-user-times"></i>
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-success" title="Ativar beneficiário"
                                                    style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                                    <i class="fas fa-user-check"></i>
                                                </button>
                                            @endif
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="editProfessionalModal-{{ $profissional->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="editProfessionalLabel-{{ $profissional->id }}"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    @include('modal._form_edicao_profissional', ['profissional' => $profissional])
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="dataTables_info" role="status" aria-live="polite">
                        Mostrando <strong>{{ $profissionais->firstItem() ?? 0 }}</strong> a
                        <strong>{{ $profissionais->lastItem() ?? 0 }}</strong> de
                        <strong>{{ $profissionais->total() }}</strong> resultados
                    </div>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    {{ $profissionais->links() }}
                </div>
            </div>
        </div>
        <div class="card-footer text-muted small">
            <div class="row">
                <div class="col-md-6">
                    <i class="fas fa-info-circle mr-1"></i>

                    @if(isset($ultimaAtualizacao))
                        Última atualização: <strong>{{ $ultimaAtualizacao->format('d/m/Y') }}</strong>
                    @endif
                </div>
                <div class="col-md-6 text-right">
                    Total de ativos: <strong>{{ $totalAtivos }}</strong> | Inativos:
                    <strong>{{ $totalInativos }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addProfessionalModal" tabindex="-1" role="dialog" aria-labelledby="addProfessionalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            @include('modal._form_cadastro_profissional')
        </div>
    </div>

@endsection

@section('js')
    @if(session('success'))
        <script>
            Swal.fire({ title: 'Sucesso!', text: '{{ session('success') }}', icon: 'success', timer: 2500, showConfirmButton: false });
        </script>
    @endif
    @if(session('error'))
        <script>
            Swal.fire({ title: 'Erro!', text: '{{ session('error') }}', icon: 'error' });
        </script>
    @endif

    <script>
        $(document).ready(function () {

            @if ($errors->any())
                @if (session('professional_id_with_error'))
                    let professionalId = "{{ session('professional_id_with_error') }}";
                    $('#editProfessionalModal-' + professionalId).modal('show');
                @else
                    $('#addProfessionalModal').modal('show');
                @endif
            @endif

            function handleFormSubmit(formSelector) {
                $(formSelector).on('submit', function (e) {
                    e.preventDefault();

                    const form = $(this);
                    const url = form.attr('action');
                    const method = form.find('input[name="_method"]').val() || 'POST';

                    form.find('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();

                    $.ajax({
                        url: url,
                        method: method,
                        data: form.serialize(),
                        beforeSend: function () {
                            Swal.fire({
                                title: 'Salvando...',
                                html: 'Por favor, aguarde.',
                                allowOutsideClick: false,
                                didOpen: () => { Swal.showLoading() }
                            });
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: response.message || 'Operação realizada com sucesso!',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function (xhr) {
                            Swal.close();
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                for (const field in errors) {
                                    const input = form.find(`[name="${field}"]`);
                                    input.addClass('is-invalid');
                                    input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                                }
                                Swal.fire('Erro de Validação', 'Por favor, corrija os campos indicados.', 'error');
                            } else {
                                Swal.fire('Erro!', 'Ocorreu um erro inesperado. Tente novamente.', 'error');
                            }
                        }
                    });
                });
            }

            handleFormSubmit('#formCadastroProfissional');
            handleFormSubmit('.form-edicao-profissional');
        });

        $(document).ready(function () {

            $('.form-toggle-status').on('submit', function (e) {
                e.preventDefault();

                const form = $(this);
                const url = form.attr('action');
                const button = form.find('button[type="submit"]');
                const icon = button.find('i');
                const originalIconClass = icon.attr('class');


                button.prop('disabled', true);
                icon.removeClass().addClass('fas fa-spinner fa-spin');

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: form.serialize(),
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Algo deu errado! Tente novamente.'
                        });
                        button.prop('disabled', false);
                        icon.removeClass().addClass(originalIconClass);
                    }
                });
            });
        });
    </script>
@endsection