@extends('adminlte::page')
@section('title', 'Notificações')
@section('pagina', 'Notificações')
@section('content_header')
<h1><i class="far fa-bell"></i> Notificações</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (count($notificacoes) > 0)
                <div class="card card-default">
                    <div class="card-header">
                        <form action="{{ route('notificacoes.marcarTodasComoLida') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="far fa-envelope-open mr-3"></i> Marcar todas como lidas
                            </button>
                        </form>
                    </div>
                    <div class="card-body">
                        @foreach ($notificacoes as $notificacao)
                            <div class="callout callout-{{ $notificacao->tipo }}">
                                <div class="row justify-content-between">
                                    <div class="col-sm-12 col-md-12 col-lg-8">
                                        <h5><i class="fas fa-birthday-cake text-warning"></i> {{ $notificacao->titulo }}</h5>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-2">
                                        <p>{{ $notificacao->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-2">
                                        <span class="badge badge-{{ $notificacao->data_leitura ? 'success' : 'warning' }}">
                                            {{ $notificacao->data_leitura ? 'Lida' : 'Não lida' }}
                                            @if ($notificacao->data_leitura)
                                                {{ $notificacao->updated_at->diffForHumans() }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{ $notificacoes->links() }}
                    </div>
                </div>
            @else
                <div class="callout callout-info">
                    <div class="row justify-content-between">
                        <h5>Nenhuma notificação encontrada !</h5>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection