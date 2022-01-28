@extends('template.aulaTeste')

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

@endsection

@section('conteudo')
    @csrf
    <div class="row">
        <div class="col-md-8 mb-2">
            <div class="card">
                <div class="embed-responsive embed-responsive-16by9">
                    {!! $aula->video !!}
                </div>
                <div class="card-body">
                    <b>
                        {!! app(App\Http\Controllers\AulaController::class)->tipo($aula->tipo, $aula->avaliacao, true) !!} {{ $aula->nome }}
                    </b>
                    <small class="text-muted-light">
                        - {{ app(App\Services\Services::class)->minuto_hora($aula->duracao) }}
                    </small>
                    <hr>
                    {{ $aula->descricao }}
                </div>
            </div>
            @if (trim($aula->texto) != '<p><br></p>' and $aula->texto != null)
                <div class="card">
                    <div class="card-body">
                        {!! $aula->texto !!}
                    </div>
                </div>
            @endif
            <!-- Lessons -->

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <a class="btn btn-success btn-block">
                        Concluir Aula
                    </a>
                </div>
            </div>

            @if (count($anexos) > 0)
                <div class="card">
                    <div class="card-body text-center">
                        <a class="btn btn-primary btn-block"> Conteúdos Auxiliares
                        </a>
                    </div>
                    <ul class="card list-group list-group-fit">
                        @foreach ($anexos as $linha)
                            <li class="list-group-item">
                                <div class="media">
                                    <div class="media-body">
                                        <div class="text-muted-light">{{ $linha->nome }}</div>
                                    </div>
                                    <div class="media-right">
                                        <a href="{{ URL::asset('storage/' . $linha->arquivo) }}"
                                            download="{{ $linha->nome }}" class="btn btn-success">
                                            <i class="material-icons mr-1">file_download</i> Baixar
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <div class="media align-items-center">
                        <div class="media-left">
                            @if ($professor->avatar != '')
                                <img src="{{ URL::asset('storage/' . $professor->avatar) }}" width="50"
                                    class="rounded-circle">
                            @else
                                <img src="{{ URL::asset('storage/avatarProfessor/padrao.png') }}" width="50"
                                    class="rounded-circle">
                            @endif
                        </div>
                        <div class="media-body">
                            <h4 class="card-title"><a>{{ $professor->nome }}</a></h4>
                            <p class="card-subtitle">
                                @if ($curso->cooprodutor)
                                    Coprodução: {{ $curso->cooprodutor }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p>{!! $professor->curriculo !!}</p>
                    @if ($professor->email)
                        <a href="mailto:{{ $professor->email }}" target="_blank" class="btn btn-light"><i
                                class="fas fa-envelope"></i></a>
                    @endif
                    @if ($professor->facebook)
                        <a href="{{ $professor->facebook }}" target="_blank" class="btn btn-light"><i
                                class="fab fa-facebook"></i></a>
                    @endif
                    @if ($professor->instagram)
                        <a href="{{ $professor->instagram }}" target="_blank" class="btn btn-light"><i
                                class="fab fa-instagram"></i></a>
                    @endif
                    @if ($professor->linkedin)
                        <a href="{{ $professor->linkedin }}" target="_blank" class="btn btn-light"><i
                                class="fab fa-linkedin"></i></a>
                    @endif
                    @if ($professor->site)
                        <a href="{{ $professor->site }}" target="_blank" class="btn btn-light"><i
                                class="fas fa-globe"></i></a>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="media align-items-center">
                        <div class="media-left">
                            @if ($curso->imagem != '')
                                <img src="{{ URL::asset('storage/' . $curso->imagem) }}" width="50">
                            @else
                                <img src="{{ URL::asset('storage/imagemCurso/padrao.png') }}" width="50">
                            @endif
                        </div>
                        <div class="media-body">
                            <h4 class="card-title"><a>{{ $curso->nome }}</a></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
