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

        @foreach ($cursos as $linha)
            <div class="card-columns">
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
                                <h4 class="card-title m-0"><a href="">{{ $linha->nome }}</a></h4>
                                <small class="text-muted">Aulas: 3 de 7</small>
                            </div>
                        </div>
                    </div>
                    <div class="progress rounded-0">
                        <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 10%"
                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="" class="btn btn-primary btn-sm">Acessar Aulas <i
                                class="material-icons btn__icon--right">play_circle_outline</i></a>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- paginação -->
        {{ $cursos->links('template.paginacao.aluno') }}
    </div>


@endsection
