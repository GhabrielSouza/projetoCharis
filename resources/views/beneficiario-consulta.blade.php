@extends('adminlte::page')

@section('title', 'Beneficiário')

@section('content_header')
<h1>Consulta de Beneficiário</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-success text-white">
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
                        <button class="btn btn-outline-success" title="Adicionar beneficiário">
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
                        <tr>
                            <td>1</td>
                            <td>Maria da Silva Santos</td>
                            <td>123.456.789-09</td>
                            <td>32 anos</td>
                            <td>São Paulo/SP</td>
                            <td>15/03/2022</td>
                            <td><span class="badge badge-success">Ativo</span></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-info" title="Visualizar completo">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-warning" title="Editar cadastro">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" title="Inativar beneficiário">
                                        <i class="fas fa-user-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>João Oliveira Pereira</td>
                            <td>987.654.321-00</td>
                            <td>45 anos</td>
                            <td>Rio de Janeiro/RJ</td>
                            <td>22/05/2021</td>
                            <td><span class="badge badge-success">Ativo</span></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-info" title="Visualizar completo">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-warning" title="Editar cadastro">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" title="Inativar beneficiário">
                                        <i class="fas fa-user-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Ana Paula Costa</td>
                            <td>456.789.123-45</td>
                            <td>28 anos</td>
                            <td>Belo Horizonte/MG</td>
                            <td>10/01/2023</td>
                            <td><span class="badge badge-warning">Pendente</span></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-info" title="Visualizar completo">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-warning" title="Editar cadastro">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-success" title="Aprovar cadastro">
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
        <!-- /.card-body -->
        <div class="card-footer text-muted small">
            <div class="row">
                <div class="col-md-6">
                    <i class="fas fa-info-circle mr-1"></i> Última atualização: 02/06/2023
                </div>
                <div class="col-md-6 text-right">
                    Total de ativos: <strong>118</strong> | Inativos: <strong>7</strong>
                </div>
            </div>
        </div>
    </div>
@endsection
