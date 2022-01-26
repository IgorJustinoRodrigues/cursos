@extends('template.aluno')

@section('title', $aula->nome . ' | ' . $curso->nome)

@section('link')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('painelAluno') }}">Início</a></li>
        <li class="breadcrumb-item"><a href="{{ route('alunoCursos') }}">Meus Cursos</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('verAulas', [$curso->id, Str::slug($curso->nome, '-') . '.html']) }}">{{ $curso->nome }}</a>
        </li>
        <li class="breadcrumb-item active">{{ $aula->nome }}</li>
    </ol>
@endsection

@section('header')
    <style>
        .dourado {
            color: #ffd400 !important;
        }

    </style>
@endsection

@section('footer')
    <script>

    </script>
@endsection

@section('conteudo')
    <form class="row" action="{{ route('concluirAulaQuiz') }}" method="post">
        @csrf
        <input type="hidden" name="aula_id" value="{{ $aula->id }}">
        <input type="hidden" name="curso_id" value="{{ $curso->id }}">
        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-body">
                    <b>
                        {!! app(App\Http\Controllers\AulaController::class)->tipo($aula->tipo, $aula->avaliacao, true) !!} {!! app(App\Http\Controllers\AulaController::class)->tipo($aula->tipo, $aula->avaliacao) !!} | {{ $aula->nome }}
                    </b>
                    <small class="text-muted-light">
                        - {{ app(App\Services\Services::class)->minuto_hora($aula->duracao) }}
                    </small>
                    <hr>
                    {{ $aula->descricao }}
                </div>
            </div>
            @php $i = 1; @endphp
            @foreach ($aula->perguntas as $pergunta)
                <div class="card">
                    <div class="card-header">
                        <div class="media align-items-center">
                            <div class="media-left">
                                <h4 class="mb-0"><strong>#{{ $i }}</strong></h4>
                            </div>
                            <div class="media-body">
                                <h4 class="card-title">
                                    {{ $pergunta->pergunta }}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="custom-controls-stacked">
                            <input type="hidden" name="pergunta_id[]" value="{{ $pergunta->id }}">
                            @foreach ($pergunta->respostas as $respostas)
                                <div class="custom-control custom-radio">
                                    <input id="resposta{{ $respostas->id }}" name="resposta{{$i - 1}}"
                                        value="{{ $respostas->id }}" type="radio" class="custom-control-input" required>
                                    <label for="resposta{{ $respostas->id }}"
                                        class="custom-control-label">{{ $respostas->resposta }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @php $i++; @endphp
            @endforeach

            <div class="card">
                <div class="card-footer">
                    <a href="{{ route('verAulas', [$curso->id, Str::slug($curso->nome, '-') . '.html']) }}"
                        class="btn btn-white">Voltar para aulas</a>
                    <button type="submit" class="btn btn-primary float-right">Corrigir <i
                            class="material-icons btn__icon--right">send</i></button>
                </div>
            </div>
        </div>
    </form>
@endsection
