@extends('adminlte::page')

@section('title', 'Salas de Aula')

@section('content_header')
<h1>Salas de Aula</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Salas</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalCadastroSala">
                    <i class="fas fa-plus"></i> Nova Sala
                </button>
            </div>
        </div>
        <div class="card-body p-0" style="display: block;">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 20%">
                            Nome da Sala
                        </th>
                        <th style="width: 30%">
                            Profissional
                        </th>
                        <th style="width: 20%">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salas as $sala)
                        <tr>
                            <td>
                                #
                            </td>
                            <td>
                                <p>
                                    {{ $sala->nome }}
                                </p>
                            </td>
                            <td>
                                <p>{{ $sala->profissional->nome_completo }}</p>
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="{{ route('salas.show', $sala->id) }}">
                                    <i class="fas fa-folder">
                                    </i>
                                    View
                                </a>
                                <button class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#modalEdicaoSala-{{ $sala->id }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Edit
                                </button>
                                <form action="{{ route('salas.destroy', $sala->id) }}" method="post" style="display:inline;"
                                    name="formDeleteSala">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash">
                                        </i>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="modalEdicaoSala-{{ $sala->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="tituloModalCadastro" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    @include('modal._form_edicao_salas', ['sala' => $sala, 'profissionais' => $profissionais]);
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalCadastroSala" tabindex="-1" role="dialog" aria-labelledby="tituloModalCadastro"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                @include('modal._form_cadastro_salas')
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('form[name="formDeleteSala"]').on('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Confirmação',
                text: 'Tem certeza que deseja excluir esta sala?',
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