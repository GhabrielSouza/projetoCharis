@extends('adminlte::page')
@section('title', 'Salas de Aula')

@section('content_header')
<h1>Alunos da Sala</h1>
@stop

@section('content')
    <div class="col-md-4 col-sm-6">
        <div class="info-box bg-gradient-success">
            <span class="info-box-icon"><i class="fas fa-user"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Professor responsável</span>
                <span class="info-box-number">{{ $sala->profissional->nome_completo }}</span>
            </div>
        </div>
    </div>

    <div class="card card-info card-outline">
        <div class="card-header ">
            <h3 class="card-title"><i class="fas fa-users mr-2"></i>Cadastro de Alunos</h3>
            <div class="card-tools">
                <div class="btn-group">
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalCadastroSalaAlunos"
                        title="Adicionar alunos à sala">
                        <i class="fas fa-user-plus mr-1"></i> Novos Alunos
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">


            <div class="table-responsive">
                <table id="beneficiariosTable" class="table table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th><i class="fas fa-user mr-1"></i>Nome Completo</th>
                            <th><i class="fas fa-id-card mr-1"></i>CPF</th>
                            <th><i class="fas fa-birthday-cake mr-1"></i>Idade</th>
                            <th><i class="fas fa-map-marker-alt mr-1"></i>Cidade</th>
                            <th class="text-center"><i class="fas fa-cog mr-1"></i>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sala->alunos as $beneficiario)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $beneficiario->nome }}</td>
                                <td>{{ $beneficiario->cpf }}</td>
                                <td>{{ \Carbon\Carbon::parse($beneficiario->data_nascimento)->age }} anos</td>
                                <td>
                                    @if($beneficiario->cidade)
                                        {{ $beneficiario->cidade->nome }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <form action="{{ route('salas.removerAluno', [$sala->id, $beneficiario->id]) }}"
                                            method="post" name="formRemoverAlunoSala">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Remover aluno da sala">
                                                <i class="fas fa-user-minus"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCadastroSalaAlunos" tabindex="-1" role="dialog" aria-labelledby="tituloModalCadastro"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                @include('modal._form_cadastro_salas_alunos', ['beneficiarios' => $beneficiarios])
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            var table = $('#beneficiariosTable').DataTable({
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

        });
    </script>

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
@endsection