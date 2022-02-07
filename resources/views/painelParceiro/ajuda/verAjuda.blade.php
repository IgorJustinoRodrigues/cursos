@extends('template.parceiro')
@section('title', 'Suporte')
@section('menu-ajuda', 'true')

@section('footer')

@endsection

@section('conteudo')
    <div class="page ">
        <div class="container page__container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('painelParceiro') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('parceiro.ajuda') }}">Ajuda</a></li>
                <li class="breadcrumb-item">{{ $ajuda->categoria }}</li>
                <li class="breadcrumb-item active">{{ $ajuda->nome }}</li>
            </ol>
            <div class="media mb-headings align-items-center">
                <div class="media-body">
                    <h1 class="h2">{{ $ajuda->nome }}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-2">
                    <div class="card">
                        <div class="card-body">
                            {!! $ajuda->texto !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <div class="card">
                        <ul class="card list-group list-group-fit">
                            @foreach ($telasAtual as $linha)
                                <li class="list-group-item @if ($linha->id == $ajuda->id) active @endif">
                                    <div class="media-left">
                                        <a class="@if ($linha->id == $ajuda->id) text-white @endif" href="{{ route('parceiro.verAjuda', [$linha->id, Str::slug($linha->nome, '-') . '.html']) }}">{{ $linha->nome }}</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <a href="{{ route('parceiro.ajuda') }}" class="btn btn-default btn-wide">Voltar</a>
                </div>
            </div>

        </div>
    </div>
@endsection
