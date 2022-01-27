@extends('template.aluno')
@section('title', 'Matricula')
@section('menu-informacoes', 'true')

@section('link')

@endsection

@section('conteudo')
    <div class="page ">
        <div class="container page__container p-0">
            <div class="row m-0">
                <div class="col-lg container-fluid page__container">
                    <div id="invoice">
                        <div class="card">
                            <div class="card-header media align-items-center">
                                <div class="media-body">
                                    <h1 class="card-title h2">Anotações</h1>
                                </div>
                                <div class="media-right d-flex align-items-center">
                                    <a href="javascript:window.print()" class="btn btn-flush text-muted d-print-none"><i
                                            class="material-icons font-size-24pt">print</i></a>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-4 d-flex align-items-center">
                                    <small class="text-black-70 mr-3">
                                        @if ($paginacao->total() > 1)
                                            Exibindo {{ $paginacao->firstItem() }} ao {{ $paginacao->lastItem() }} de
                                            {{ $paginacao->total() }} Registros
                                        @elseif($paginacao->total() == 1)
                                            {{ $paginacao->total() }} Registro
                                        @else
                                            Não há registros
                                        @endif
                                    </small>
                                    <!-- Search -->
                                    <form class="flex search-form form-control-rounded search-form--light mb-2 col-md-12"
                                        action="{{ route('aulasFeitas') }}" method="GET" style="min-width: 200px;">
                                        <input type="hidden" name="page" value="1" />
                                        <input type="text" class="form-control" placeholder="Digite sua busca" id="busca"
                                            value="{{ $busca }}" name="busca" required>
                                        <button class="btn pr-3" type="submit" role="button"><i
                                                class="material-icons">search</i></button>
                                        @if (@$busca)
                                            <a href="{{ route('aulasFeitas') }}" class="btn pr-3 text-danger"
                                                type="button" role="button"><i class="material-icons">close</i></a>
                                        @endif
                                    </form>
                                </div>
                                <div class="row">
                                    @foreach ($paginacao as $linha)

                                    <div class="card card-body">
                                        <div class="d-flex">
                                            <div class="flex">
                                                <p class="d-flex align-items-center mb-2">
                                                    <a href="{{ route('aula', [$linha->curso_id, Str::slug($linha->curso, '-'), $linha->aula_id, Str::slug($linha->aula, '-') . '.html']) }}"
                                                        class="text-body mr-2"><strong>{{ $linha->aula }}</strong></a>
                                                    <a href="{{ route('verAulas', [$linha->curso_id, Str::slug($linha->curso, '-') . '.html']) }}" class="text-muted">{{ $linha->curso }}</a>
                                                </p>
                                                <hr>
                                                {!! $linha->anotacao !!}
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
