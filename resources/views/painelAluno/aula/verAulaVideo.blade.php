@extends('template.aluno')

@section('link')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="student-dashboard.html">Início</a></li>
        <li class="breadcrumb-item"><a href="student-browse-courses.html">Meus Cursos</a></li>
        <li class="breadcrumb-item"><a href="student-browse-courses.html">{{ $curso->nome }}</a></li>
        <li class="breadcrumb-item active">{{ $aula->nome }}</li>
    </ol>
@endsection

@section('conteudo')
    <h1 class="h2">{{ $curso->nome }}</h1>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="embed-responsive embed-responsive-16by9">
                    {!! $aula->video !!}
                </div>
                <div class="card-body">
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
                <textarea id="anotacao" placeholder="Suas anotações desta aula" rows="4" class="form-control"></textarea>
                <div class="d-flex mt-2">
                    <div class="flex">
                        <a href="{{ route('verAulas', [$curso->id, Str::slug($curso->nome, '-') . '.html']) }}"
                            class="btn btn-sm btn-default btn-wide">Voltar para aulas</a>
                    </div>
                    <a class="btn btn-sm btn-success">Salvar</a>
                </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <p>
                        <a href="student-cart.html" class="btn btn-success btn-block flex-column">
                            <i class="material-icons" style="font-size: 20px">cloud_download</i> Baixar Conteúdo Auxiliar
                        </a>
                    </p>
                </div>
            </div>
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
                            <h4 class="card-title"><a href="student-profile.html">{{ $professor->nome }}</a></h4>
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
                <ul class="list-group list-group-fit">
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <div class="media-left">
                                <i class="material-icons text-muted-light">assessment</i>
                            </div>
                            <div class="media-body">
                                Duração do curso {{ app(App\Services\Services::class)->minuto_hora($tempoTotal) }}
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <div class="media-left">
                                <i class="material-icons text-muted-light">schedule</i>
                            </div>
                            <div class="media-body">
                                Aulas concluidas
                                {{ app(App\Services\Services::class)->minuto_hora($tempoTotalConcluido) }}
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Avalie sua aula</h4>
                </div>
                <div class="card-body">
                    <div class="rating">
                        <i class="material-icons">star</i>
                        <i class="material-icons">star</i>
                        <i class="material-icons">star</i>
                        <i class="material-icons">star</i>
                        <i class="material-icons">star_border</i>
                    </div>
                    <small class="text-muted">Média 4.5</small>
                </div>
            </div>
        </div>
    </div>
@endsection
