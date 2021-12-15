@extends('template.aluno')

@section('link')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="student-dashboard.html">Início</a></li>
        <li class="breadcrumb-item"><a href="student-browse-courses.html">Meus Cursos</a></li>
        <li class="breadcrumb-item active">Nome do Curso</li>
    </ol>
@endsection

@section('conteudo')
    <h1 class="h2">Nome do Curso</h1>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item"
                        src="https://player.vimeo.com/video/97243285?title=0&amp;byline=0&amp;portrait=0"
                        allowfullscreen=""></iframe>
                </div>
                <div class="card-body">
                    Breve descrição da Aula, com informações adicionais.
                </div>
            </div>

            <!-- Lessons -->
            <ul class="card list-group list-group-fit">
                <li class="list-group-item">
                    <div class="media">
                        <div class="media-left">
                            <div class="text-muted">1.</div>
                        </div>
                        <div class="media-body">
                            <a href="#">Introdução</a>
                        </div>
                        <div class="media-right">
                            <small class="text-muted-light">2:03</small>
                        </div>
                    </div>
                </li>
                <li class="list-group-item active">
                    <div class="media">
                        <div class="media-left">2.</div>
                        <div class="media-body">
                            <a class="text-white" href="#">Aula 2</a>
                        </div>
                        <div class="media-right">
                            <small>25:01</small>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="media">
                        <div class="media-left">
                            <div class="text-muted">3.</div>
                        </div>
                        <div class="media-body">
                            <a href="#">Aula 3</a>
                        </div>
                        <div class="media-right">
                            <small class="text-muted-light">12:10</small>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="media">
                        <div class="media-left">
                            <div class="text-muted">4.</div>
                        </div>
                        <div class="media-body">
                            <div class="text-muted-light">Aula 4</div>
                        </div>
                        <div class="media-right">
                            <small class="text-muted-light">10:10</small>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="media">
                        <div class="media-left">
                            <div class="text-muted">6.</div>
                        </div>
                        <div class="media-body">
                            <div class="text-muted-light">Avaliação</div>
                        </div>
                        <div class="media-right">
                            <small class="text-muted-light">5:00</small>
                        </div>
                    </div>
                </li>
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
                                Tempo de curso
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <div class="media-left">
                                <i class="material-icons text-muted-light">schedule</i>
                            </div>
                            <div class="media-body">
                                2 <small class="text-muted">hrs</small> &nbsp; 26 <small
                                    class="text-muted">min</small>
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
