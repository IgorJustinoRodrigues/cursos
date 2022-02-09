@extends('template.vendedor')
@section('title', 'Suporte')
@section('menu-ajuda', 'true')

@section('footer')

@endsection

@section('conteudo')
    <div class="page ">
        <div class="container page__container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('painelVendedor') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Ajuda</li>
            </ol>
            <div class="media mb-headings align-items-center">
                <div class="media-body">
                    <h1 class="h2">Tela de Ajuda</h1>
                </div>
            </div>
            <div class="card-columns">
                @foreach ($categoriasAjuda as $linhaAjuda)
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <div class="flex">
                                <h4 class="card-title">{{ $linhaAjuda->nome }}</h4>
                            </div>
                            <div style="font-size: 50px;">
                                @if ($linhaAjuda->icone != '')
                                    {!! $linhaAjuda->icone !!}
                                @else
                                    <i class="icofont-learn"></i>
                                @endif
                            </div>
                        </div>
                        <ul class="list-group list-group-fit">
                            @foreach ($linhaAjuda->telas as $linha)
                            <li class="list-group-item">
                                <a href="{{ route('vendedor.verAjuda', [$linha->id, Str::slug($linha->nome, '-') . '.html']) }}" class="text-body"><i
                                        class="material-icons float-right text-muted">trending_flat</i>
                                    <strong>{{ $linha->nome }}</strong></a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
