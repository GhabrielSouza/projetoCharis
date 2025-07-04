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
        <!-- /.card-header -->
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

                            <div class="modal fade" id="modalEditarBeneficiario-{{ $beneficiario->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="tituloModalEdicao-{{ $beneficiario->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">

                                        <form id="formEdicaoBeneficiario-{{ $beneficiario->id }}"
                                            action="{{ route('beneficiarios.update', $beneficiario->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-header bg-orange text-dark">
                                                <h5 class="modal-title" id="tituloModalEdicao-{{ $beneficiario->id }}">
                                                    <i class="fas fa-edit mr-2"></i>Editar Cadastro de:
                                                    <strong>{{ $beneficiario->nome }}</strong>
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">

                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <div class="form-group">
                                                            <label for="nome-{{ $beneficiario->id }}">Nome Completo</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend"><span
                                                                        class="input-group-text"><i
                                                                            class="fas fa-user"></i></span></div>
                                                                <input type="text" id="nome-{{ $beneficiario->id }}" name="nome"
                                                                    class="form-control"
                                                                    value="{{ old('nome', $beneficiario->nome) }}" required>
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label for="data_nascimento-{{ $beneficiario->id }}">Data de
                                                                Nascimento</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend"><span
                                                                        class="input-group-text"><i
                                                                            class="fas fa-calendar-alt"></i></span></div>
                                                                <input type="date" id="data_nascimento-{{ $beneficiario->id }}"
                                                                    name="data_nascimento" class="form-control"
                                                                    value="{{ old('data_nascimento', $beneficiario->data_nascimento->format('Y-m-d')) }}"
                                                                    required>
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label for="cpf-{{ $beneficiario->id }}">CPF</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend"><span
                                                                        class="input-group-text"><i
                                                                            class="fas fa-id-card"></i></span></div>
                                                                <input type="text" id="cpf-{{ $beneficiario->id }}" name="cpf"
                                                                    class="form-control cpf-mask"
                                                                    value="{{ old('cpf', $beneficiario->cpf) }}" required>
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label for="telefone-{{ $beneficiario->id }}">Telefone</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend"><span
                                                                        class="input-group-text"><i
                                                                            class="fas fa-phone"></i></span></div>
                                                                <input type="text" id="telefone-{{ $beneficiario->id }}"
                                                                    name="telefone" class="form-control phone-mask"
                                                                    value="{{ old('telefone', $beneficiario->telefone) }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="form-group">
                                                            <label for="endereco-{{ $beneficiario->id }}">Endereço</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend"><span
                                                                        class="input-group-text"><i
                                                                            class="fas fa-map-marker-alt"></i></span></div>
                                                                <input type="text" id="endereco-{{ $beneficiario->id }}"
                                                                    name="endereco" class="form-control"
                                                                    value="{{ old('endereco', optional($beneficiario->endereco)->logradouro) }}"
                                                                    placeholder="Endereço completo">
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label
                                                                for="escolaridade-{{ $beneficiario->id }}">Escolaridade</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend"><span
                                                                        class="input-group-text"><i
                                                                            class="fas fa-graduation-cap"></i></span></div>
                                                                <select id="escolaridade-{{ $beneficiario->id }}"
                                                                    name="escolaridade" class="form-control">
                                                                    <option value="">Selecione...</option>

                                                                    <option value="Fundamental Incompleto" {{ old('escolaridade', $beneficiario->escolaridade) == 'Fundamental Incompleto' ? 'selected' : '' }}>Fundamental Incompleto</option>
                                                                    <option value="Fundamental Completo" {{ old('escolaridade', $beneficiario->escolaridade) == 'Fundamental Completo' ? 'selected' : '' }}>Fundamental Completo</option>
                                                                    <option value="Médio Incompleto" {{ old('escolaridade', $beneficiario->escolaridade) == 'Médio Incompleto' ? 'selected' : '' }}>Médio Incompleto</option>
                                                                    <option value="Médio Completo" {{ old('escolaridade', $beneficiario->escolaridade) == 'Médio Completo' ? 'selected' : '' }}>Médio Completo</option>
                                                                    <option value="Superior Incompleto" {{ old('escolaridade', $beneficiario->escolaridade) == 'Superior Incompleto' ? 'selected' : '' }}>Superior Incompleto</option>
                                                                    <option value="Superior Completo" {{ old('escolaridade', $beneficiario->escolaridade) == 'Superior Completo' ? 'selected' : '' }}>Superior Completo</option>
                                                                    <option value="Pós-graduação" {{ old('escolaridade', $beneficiario->escolaridade) == 'Pós-graduação' ? 'selected' : '' }}>Pós-graduação</option>
                                                                    <option value="Analfabeto" {{ old('escolaridade', $beneficiario->escolaridade) == 'Analfabeto' ? 'selected' : '' }}>Analfabeto</option>
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label for="cadunico-{{ $beneficiario->id }}">Número do
                                                                CadÚnico</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend"><span
                                                                        class="input-group-text"><i
                                                                            class="fas fa-file-alt"></i></span></div>
                                                                <input type="text" id="cadunico-{{ $beneficiario->id }}"
                                                                    name="cadunico" class="form-control"
                                                                    value="{{ old('cadunico', $beneficiario->cadunico) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label><i class="fas fa-wheelchair mr-1"></i> Limitações</label>
                                                    @php
    $limitacoes_salvas = old('limitacoes', json_decode($beneficiario->limitacoes, true) ?? []);
                                                    @endphp
                                                    <div class="border p-3 rounded">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="custom-control custom-checkbox">

                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="cognitiva-{{ $beneficiario->id }}"
                                                                        name="limitacoes[]" value="Cognitiva" {{ is_array($limitacoes_salvas) && in_array('Cognitiva', $limitacoes_salvas) ? 'checked' : '' }}>
                                                                    <label class="custom-control-label"
                                                                        for="cognitiva-{{ $beneficiario->id }}">Cognitiva</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="locomocao-{{ $beneficiario->id }}"
                                                                        name="limitacoes[]" value="Locomoção" {{ is_array($limitacoes_salvas) && in_array('Locomoção', $limitacoes_salvas) ? 'checked' : '' }}>
                                                                    <label class="custom-control-label"
                                                                        for="locomocao-{{ $beneficiario->id }}">Locomoção</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="visao-{{ $beneficiario->id }}" name="limitacoes[]"
                                                                        value="Visão" {{ is_array($limitacoes_salvas) && in_array('Visão', $limitacoes_salvas) ? 'checked' : '' }}>
                                                                    <label class="custom-control-label"
                                                                        for="visao-{{ $beneficiario->id }}">Visão</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="audicao-{{ $beneficiario->id }}" name="limitacoes[]"
                                                                        value="Audição" {{ is_array($limitacoes_salvas) && in_array('Audição', $limitacoes_salvas) ? 'checked' : '' }}>
                                                                    <label class="custom-control-label"
                                                                        for="audicao-{{ $beneficiario->id }}">Audição</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-12">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend"><span
                                                                            class="input-group-text">Outras</span></div>
                                                                    <input type="text" class="form-control"
                                                                        name="outras_limitacoes"
                                                                        value="{{ old('outras_limitacoes', $beneficiario->outras_limitacoes) }}"
                                                                        placeholder="Especifique outras limitações">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="observacoes-{{ $beneficiario->id }}"><i
                                                            class="fas fa-comment-dots mr-1"></i> Observações</label>
                                                    <textarea id="observacoes-{{ $beneficiario->id }}" name="observacoes"
                                                        class="form-control"
                                                        rows="3">{{ old('observacoes', $beneficiario->observacoes) }}</textarea>
                                                </div>
                                            </div>


                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                                        class="fas fa-times mr-1"></i> Cancelar</button>
                                                <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i>
                                                    Salvar Alterações</button>
                                            </div>
                                        </form>
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

    <div class="modal fade" id="modalCadastroBeneficiario" tabindex="-1" role="dialog" aria-labelledby="tituloModalCadastro"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="formCadastroBeneficiario" action="{{ route('beneficiarios.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-orange text-white">
                        <h5 class="modal-title" id="tituloModalCadastro">
                            <i class="fas fa-user-plus mr-2"></i>Cadastro de Beneficiário
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <!-- Coluna 1 -->
                            <div class="col-md-6">
                                {{-- Nome --}}
                                <div class="form-group">
                                    <label for="nome">Nome Completo</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" id="nome" name="nome" class="form-control"
                                            placeholder="Nome completo" required>
                                    </div>
                                </div>

                                {{-- Data de nascimento --}}
                                <div class="form-group">
                                    <label for="data_nascimento">Data de Nascimento</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" id="data_nascimento" name="data_nascimento" class="form-control"
                                            required>
                                    </div>
                                </div>

                                {{-- CPF --}}
                                <div class="form-group">
                                    <label for="cpf">CPF</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        </div>
                                        <input type="text" id="cpf" name="cpf" class="form-control cpf-mask"
                                            placeholder="000.000.000-00" required>
                                    </div>
                                </div>

                                {{-- Telefone --}}
                                <div class="form-group">
                                    <label for="telefone">Telefone</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" id="telefone" name="telefone" class="form-control phone-mask"
                                            placeholder="(00) 00000-0000">
                                    </div>
                                </div>
                            </div>

                            <!-- Coluna 2 -->
                            <div class="col-md-6">
                                {{-- Endereço --}}
                                <div class="form-group">
                                    <label for="endereco">Endereço</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        </div>
                                        <input type="text" id="endereco" name="endereco" class="form-control"
                                            placeholder="Endereço completo">
                                    </div>
                                </div>

                                {{-- Escolaridade --}}
                                <div class="form-group">
                                    <label for="escolaridade">Escolaridade</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                        </div>
                                        <select id="escolaridade" name="escolaridade" class="form-control">
                                            <option value="">Selecione...</option>
                                            <option value="Fundamental Incompleto">Fundamental Incompleto</option>
                                            <option value="Fundamental Completo">Fundamental Completo</option>
                                            <option value="Médio Incompleto">Médio Incompleto</option>
                                            <option value="Médio Completo">Médio Completo</option>
                                            <option value="Superior Incompleto">Superior Incompleto</option>
                                            <option value="Superior Completo">Superior Completo</option>
                                            <option value="Pós-graduação">Pós-graduação</option>
                                            <option value="Analfabeto">Analfabeto</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- CadÚnico --}}
                                <div class="form-group">
                                    <label for="cadunico">Número do CadÚnico</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                        </div>
                                        <input type="text" id="cadunico" name="cadunico" class="form-control"
                                            placeholder="Número do CadÚnico">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Linha de Limitações -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><i class="fas fa-wheelchair mr-1"></i> Limitações</label>
                                    <div class="border p-3 rounded">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="cognitiva"
                                                        name="limitacoes[]" value="Cognitiva">
                                                    <label class="custom-control-label" for="cognitiva">Cognitiva</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="locomocao"
                                                        name="limitacoes[]" value="Locomoção">
                                                    <label class="custom-control-label" for="locomocao">Locomoção</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="visao"
                                                        name="limitacoes[]" value="Visão">
                                                    <label class="custom-control-label" for="visao">Visão</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="audicao"
                                                        name="limitacoes[]" value="Audição">
                                                    <label class="custom-control-label" for="audicao">Audição</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Outras</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="outras_limitacoes"
                                                        placeholder="Especifique outras limitações">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Observações -->
                        <div class="form-group">
                            <label for="observacoes"><i class="fas fa-comment-dots mr-1"></i> Observações</label>
                            <textarea id="observacoes" name="observacoes" class="form-control" rows="3"
                                placeholder="Informações adicionais relevantes"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer ">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-1"></i> Salvar Cadastro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
        <!-- Mensagem de sucesso ao voltar da rota -->
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
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'Entendi'
                });
            </script>
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('formCadastroBeneficiario');
                if (form) {
                    form.addEventListener('submit', function (e) {
                        Swal.fire({
                            title: 'Salvando...',
                            text: 'Por favor, aguarde.',

                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    });
                }
            });
        </script>
@endsection
