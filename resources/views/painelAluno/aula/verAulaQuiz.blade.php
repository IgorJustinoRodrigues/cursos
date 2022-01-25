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
    @csrf
    <div class="row">
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
            <div class="card">
                <div class="card-header">
                    <div class="media align-items-center">
                        <div class="media-left">
                            <h4 class="mb-0"><strong>#9</strong></h4>
                        </div>
                        <div class="media-body">
                            <h4 class="card-title">
                                Github command to deploy comits?
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="custom-controls-stacked">
                        <div class="custom-control custom-radio">
                            <input id="radioStacked1" name="radio-stacked" type="radio" class="custom-control-input">
                            <label for="radioStacked1" class="custom-control-label">Toggle this custom radio</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="radioStacked2" name="radio-stacked" type="radio" class="custom-control-input">
                            <label for="radioStacked2" class="custom-control-label">Or toggle this other custom radio</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="media align-items-center">
                        <div class="media-left">
                            <h4 class="mb-0"><strong>#9</strong></h4>
                        </div>
                        <div class="media-body">
                            <h4 class="card-title">
                                Github command to deploy comits?
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="custom-controls-stacked">
                        <div class="custom-control custom-radio">
                            <input id="radioStacked1" name="radio-stacked" type="radio" class="custom-control-input">
                            <label for="radioStacked1" class="custom-control-label">Toggle this custom radio</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="radioStacked2" name="radio-stacked" type="radio" class="custom-control-input">
                            <label for="radioStacked2" class="custom-control-label">Or toggle this other custom radio</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="media align-items-center">
                        <div class="media-left">
                            <h4 class="mb-0"><strong>#9</strong></h4>
                        </div>
                        <div class="media-body">
                            <h4 class="card-title">
                                Github command to deploy comits?
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="custom-controls-stacked">
                        <div class="custom-control custom-radio">
                            <input id="radioStacked1" name="radio-stacked" type="radio" class="custom-control-input">
                            <label for="radioStacked1" class="custom-control-label">Toggle this custom radio</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="radioStacked2" name="radio-stacked" type="radio" class="custom-control-input">
                            <label for="radioStacked2" class="custom-control-label">Or toggle this other custom radio</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="media align-items-center">
                        <div class="media-left">
                            <h4 class="mb-0"><strong>#9</strong></h4>
                        </div>
                        <div class="media-body">
                            <h4 class="card-title">
                                Github command to deploy comits?
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="custom-controls-stacked">
                        <div class="custom-control custom-radio">
                            <input id="radioStacked1" name="radio-stacked" type="radio" class="custom-control-input">
                            <label for="radioStacked1" class="custom-control-label">Toggle this custom radio</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="radioStacked2" name="radio-stacked" type="radio" class="custom-control-input">
                            <label for="radioStacked2" class="custom-control-label">Or toggle this other custom radio</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-footer">
                    <a href="#" class="btn btn-white">Skip</a>
                    <a href="#" class="btn btn-success float-right">Submit <i class="material-icons btn__icon--right">send</i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
