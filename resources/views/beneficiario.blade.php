@extends('adminlte::page')

@section('title', 'Beneficiário')

@section('content_header')
<h1>Cadastro de Beneficiário</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-orange text-white">
            <h3 class="card-title"><i class="fas fa-users mr-2"></i>Cadastro de Beneficiários</h3>
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
                        <button class="btn btn-outline-success" data-toggle="modal" data-target="#modalCadastroBeneficiario"
                            title="Adicionar beneficiário">
                            <i class="fas fa-user-plus mr-1"></i> Novo
                        </button>
                        <button class="btn btn-outline-primary" title="Imprimir relatório">
                            <i class="fas fa-print mr-1"></i> Imprimir
                        </button>
                        <button class="btn btn-outline-info" title="Exportar dados">
                            <i class="fas fa-file-export mr-1"></i> Exportar
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="search" class="form-control" placeholder="Pesquisar beneficiários..." id="searchInput">
                        <div class="input-group-append">
                            <button class="btn btn-success" id="searchButton">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th><i class="fas fa-user mr-1"></i>Nome Completo</th>
                            <th><i class="fas fa-id-card mr-1"></i>CPF</th>
                            <th><i class="fas fa-birthday-cake mr-1"></i>Idade</th>
                            <th><i class="fas fa-map-marker-alt mr-1"></i>Cidade</th>
                            <th><i class="fas fa-calendar-check mr-1"></i>Data Cadastro</th>
                            <th><i class="fas fa-heartbeat mr-1"></i>Status</th>
                            <th class="text-center"><i class="fas fa-cog mr-1"></i>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($beneficiarios as $beneficiario)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $beneficiario->nome }}</td>
                                <td>{{ $beneficiario->cpf }}</td>
                                <td>{{ \Carbon\Carbon::parse($beneficiario->data_nascimento)->age }} anos</td>
                                <td>
                                    @if($beneficiario->endereco && $beneficiario->endereco->cidade)
                                        {{ $beneficiario->endereco->cidade->nome }}/{{ $beneficiario->endereco->cidade->estado->sigla }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $beneficiario->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if ($beneficiario->status == 'ativo')
                                        <span class="badge badge-success">Ativo</span>
                                    @elseif ($beneficiario->status == 'pendente')
                                        <span class="badge badge-warning">Pendente</span>
                                    @else
                                        <span class="badge badge-danger">Inativo</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">

                                        <button class="btn btn-info" title="Visualizar completo">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button data-toggle="modal"
                                            data-target="#modalEditarBeneficiario-{{ $beneficiario->id }}"
                                            class="btn btn-warning" title="Editar cadastro">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button data-toggle="modal"
                                            data-target="#modalEditarBeneficiario-{{ $beneficiario->id }}"
                                            class="btn btn-primary" title="Registro de Cesta Básica">
                                            <i class="fas fa-shopping-basket"></i>
                                        </button>

                                        <form action="{{ route('beneficiarios.toggleStatus', $beneficiario->id) }}"
                                            method="POST" style="display: inline;">
                                            @csrf

                                            @if ($beneficiario->status == 'ativo')
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

                            {{-- Modal de Edição (agora com include) --}}
                            <div class="modal fade" id="modalEditarBeneficiario-{{ $beneficiario->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="tituloModalEdicao-{{ $beneficiario->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        @include('modal._form_edicao_beneficiario', ['beneficiario' => $beneficiario])
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="dataTables_info">
                        Mostrando <strong>1</strong> a <strong>3</strong> de <strong>125</strong> beneficiários
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class="pagination pagination-sm justify-content-end">
                        <li class="page-item disabled">
                            <a class="page-link" href="#"><i class="fas fa-angle-left"></i></a>
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
                            <a class="page-link" href="#"><i class="fas fa-angle-right"></i></a>
                        </li>
                    </ul>
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
                    Total de ativos: <strong>{{ $totalAtivos }}</strong> | Inativos: <strong>{{ $totalInativos }}</strong>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Cadastro (agora com include) --}}
    <div class="modal fade" id="modalCadastroBeneficiario" tabindex="-1" role="dialog" aria-labelledby="tituloModalCadastro"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                @include('modal._form_cadastro_beneficiario')
            </div>
        </div>
    </div>
@endsection

<!-- @section('js')
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
            // Reabre modal de cadastro se tiver erro no cadastro
            @if ($errors->any())
                @if (old('nome') || old('cpf'))
                    console.log('Reabrindo modal de cadastro...');
                    $('#modalCadastroBeneficiario').modal('show');
                @endif

                    // Reabre modal de edição se veio com session ID
                    @if (session('beneficiario_id_com_erro'))
                        let id = "{{ session('beneficiario_id_com_erro') }}";
                        console.log('Reabrindo modal de edição com ID:', id);
                        $('#modalEditarBeneficiario-' + id).modal('show');
                    @endif
            @endif

            // Loader para cadastro
            $('#formCadastroBeneficiario').on('submit', function () {
                Swal.fire({
                    title: 'Salvando...',
                    text: 'Por favor, aguarde.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });

            // Loader para edição
            $('form[id^="formEdicaoBeneficiario-"]').on('submit', function () {
                Swal.fire({
                    title: 'Salvando Alterações...',
                    text: 'Por favor, aguarde.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });
        });
    </script>
@endsection -->

@section('js')
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
            @if ($errors->any() && (old('nome') || old('cpf')))
                console.log('Reabrindo modal de cadastro com erros...');
                $('#modalCadastroBeneficiario').modal('show');
            @endif

                @if ($errors->any() && session('beneficiario_id_com_erro'))
                    let beneficiarioIdComErro = "{{ session('beneficiario_id_com_erro') }}";
                    console.log('Reabrindo modal de edição com erros para o ID:', beneficiarioIdComErro);
                    $('#modalEditarBeneficiario-' + beneficiarioIdComErro).modal('show');
                @endif

            $('#formCadastroBeneficiario').on('submit', function () {
                Swal.fire({
                    title: 'Salvando...',
                    text: 'Por favor, aguarde.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });

            $('form[id^="formEdicaoBeneficiario-"]').on('submit', function () {
                Swal.fire({
                    title: 'Salvando Alterações...',
                    text: 'Por favor, aguarde.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });

            $('.modal').on('shown.bs.modal', function () {
                $(this).find('.modal-body').scrollTop(0);
            });
        });
    </script>
@endsection