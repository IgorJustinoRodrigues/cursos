@extends('template.aluno')
@section('menu-meusCursos', 'true')

@section('link')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="student-dashboard.html">Início</a></li>
        <li class="breadcrumb-item active">Meus Cursos</li>
    </ol>
@endsection

@section('conteudo')
    <div class="container-fluid page__container">
        <div class="media mb-headings align-items-center">
            <div class="media-body">
                <h1 class="h2">Meus cursos</h1>
            </div>
        </div>
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
                action="{{ route('alunoCursos') }}" method="GET" style="min-width: 200px;">
                <input type="hidden" name="page" value="1" />
                <input type="text" class="form-control" placeholder="Digite sua busca" id="busca"
                    value="{{ $busca }}" name="busca" required>
                <button class="btn pr-3" type="submit" role="button"><i class="material-icons">search</i></button>
                @if (@$busca)
                    <a href="{{ route('alunoCursos') }}" class="btn pr-3 text-danger" type="button" role="button"><i
                            class="material-icons">close</i></a>
                @endif
            </form>
        </div>
        <div class="card-columns">
            @foreach ($paginacao as $linha)
                <div class="card">
                    <div class="card-header">
                        <div class="media">
                            <div class="media-left">
                                <a href="">

                                    @if ($linha->imagem != '')
                                        <img src="{{ URL::asset('storage/' . $linha->imagem) }}" alt="" width="100"
                                            class="rounded">
                                    @else
                                        <img src="{{ URL::asset('storage/imagemCurso/padrao.png') }}" alt="" width="100"
                                            class="rounded">
                                    @endif
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="card-title m-0"><a
                                        href="{{ route('verAulas', [$linha->id, Str::slug($linha->nome, '-') . '.html']) }}">{{ $linha->nome }}</a>
                                </h4>
                                <small class="text-muted">Aulas concluidas: {{ $linha->total_aula_concluido }} de
                                    {{ $linha->total_aula }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="progress rounded-0">
                        <div class="progress-bar progress-bar-striped @if ($linha->porcentagem == 100) bg-success @else bg-primary @endif" role="progressbar"
                            style="width: {{ $linha->porcentagem }}%" aria-valuenow="{{ $linha->porcentagem }}"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="card-footer bg-white">
                        @if ($linha->porcentagem == 100)
                            <a href="{{ route('verAulas', [$linha->id, Str::slug($linha->nome, '-') . '.html']) }}"
                                class="btn btn-primary btn-sm">Rever Aulas <i
                                    class="material-icons btn__icon--right">play_circle_outline</i></a>

                            <a href="{{ route('verAulas', [$linha->id, Str::slug($linha->nome, '-') . '.html']) }}"
                                class="btn btn-success btn-sm">Certificado <i
                                    class="material-icons btn__icon--right">play_circle_outline</i></a>
                        @else
                            <a href="{{ route('verAulas', [$linha->id, Str::slug($linha->nome, '-') . '.html']) }}"
                                class="btn btn-primary btn-sm">Acessar Aulas <i
                                    class="material-icons btn__icon--right">play_circle_outline</i></a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <!-- paginação -->
        {{ $paginacao->links('template.paginacao.aluno', ['busca' => $busca]) }}
    </div>


@endsection
