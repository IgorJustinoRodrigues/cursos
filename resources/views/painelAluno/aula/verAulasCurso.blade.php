@extends('template.aluno')
@section('menu-meusCursos', 'true')

@section('link')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('painelAluno') }}">Início</a></li>
        <li class="breadcrumb-item"><a href="{{ route('alunoCursos') }}">Meus Cursos</a></li>
        <li class="breadcrumb-item active">{{ $curso->nome }}</li>
    </ol>
@endsection

@section('conteudo')
    <div class="container page__container">
        <div class="media mb-headings align-items-center">
            <div class="media-left">
                <img src="assets/images/vuejs.png" alt="" width="80" class="rounded">
            </div>
            <div class="media-body">
                <h1 class="h2">{{ $curso->nome }}</h1>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{!! app(App\Http\Controllers\AulaController::class)->tipo($atual->tipo, $atual->avaliacao, true) !!} {{ $atual->nome }}</h4>
            </div>
            <div class="card-body media align-items-center">
                <div class="media-body">
                    <h4 class="mb-0">{!! $atual->descricao !!}</h4>
                    <span
                        class="text-muted-light">{{ app(App\Services\Services::class)->minuto_hora($atual->duracao) }}</span>
                </div>
                <div class="media-right">
                    <a href="fixed-student-take-quiz.html" class="btn btn-success">Continuar curso <i
                            class="material-icons btn__icon--right">play_arrow</i></a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Aulas</h4>
            </div>
            <ul class="list-group list-group-fit mb-0">
                @php $i = 1; @endphp
                @foreach ($aulas as $linha)
                    <li class="list-group-item">
                        <div class="media">
                            <div class="media-left">
                                <div class="text-muted-light">{{ $i }}.</div>
                            </div>
                            <div class="media-body">
                                <a href=""
                                    class="                                
                                @if ($linha->conclusao != null)
                                    text-success
                                @endif
                                    ">
                                    {!! app(App\Http\Controllers\AulaController::class)->tipo($linha->tipo, $linha->avaliacao, true) !!}
                                    {{ $linha->nome }}
                                </a>
                                <small class="text-muted-light ml-3">
                                    {{ app(App\Services\Services::class)->minuto_hora($linha->duracao) }}
                                </small>
                            </div>
                            <div class="media-right">
                                @if ($i <= $atual->indice)
                                    <a href="fixed-student-take-quiz.html" class="btn btn-success btn-sm">
                                        Rever aula
                                        <i class="material-icons btn__icon--right">play_arrow</i>
                                    </a>
                                @elseif($i - 1 == $atual->indice)
                                    <a href="fixed-student-take-quiz.html" class="btn btn-primary btn-sm">
                                        Continuar
                                        <i class="material-icons btn__icon--right">play_arrow</i>
                                    </a>
                                @else
                                    <a class="btn btn-light btn-sm">
                                        <i class="material-icons btn__icon--right">lock</i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </li>
                    @php $i++ @endphp
                @endforeach
            </ul>
        </div>
    </div>
@endsection
