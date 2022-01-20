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
                    {!! $aula->texto !!}
                </div>
                <div class="card-body">
                    {{ $aula->descricao }}
                </div>
            </div>


            <!-- Lessons -->
            <ul class="card list-group list-group-fit">
                @php $i = 1; @endphp
                @foreach ($aulas as $linha)
                <li class="list-group-item">
                    <div class="media">
                        <div class="media-left">
                            <div class="text-muted">{{$i++}}.</div>
                        </div>
                        <div class="media-body">
                            <a href="{{ route('alunoAula', [$curso, $linha->id, $aula->nome]) }}">{{ $linha->nome }}</a>
                        </div>
                        <div class="media-right">
                            <small class="text-muted-light">{{ app(App\Services\Services::class)->minuto_hora($linha->duracao) }}</small>
                        </div>
                    </div>
                </li>
                @endforeach
            
            </ul>
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
                            <img src="{{ URL::asset('template/images/people/110/guy-6.jpg') }}" alt="About Adrian"
                                width="50" class="rounded-circle">
                        </div>
                        <div class="media-body">
                            <h4 class="card-title"><a href="student-profile.html">Nome do Professor</a></h4>
                            <p class="card-subtitle">Professor</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p>Descrição Professor</p>
                    <a href="" class="btn btn-light"><i class="fab fa-facebook"></i></a>
                    <a href="" class="btn btn-light"><i class="fab fa-instagram"></i></a>
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
                                Aulas concluidas {{ app(App\Services\Services::class)->minuto_hora($tempoTotalConcluido) }}
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
