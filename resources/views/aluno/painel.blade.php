@extends('template.aluno')

@section('link')
@endsection

@section('footer')
<!-- Global Settings -->
<script src="{{ URL::asset('template/js/settings.js') }}"></script>

<!-- Moment.js -->
<script src="{{ URL::asset('template/vendor/moment.min.js') }}"></script>
<script src="{{ URL::asset('template/vendor/moment-range.js') }}"></script>

<!-- Chart.js -->
<script src="{{ URL::asset('template/vendor/Chart.min.js') }}"></script>
<script src="{{ URL::asset('template/js/chartjs.js') }}"></script>

<!-- Student Dashboard Page JS -->
<!-- <script src="{{ URL::asset('template/js/chartjs-rounded-bar.js') }}"></script> -->
<script src="{{ URL::asset('template/js/page.student-dashboard.js') }}"></script>
@endsection

@section('conteudo')
    <h1 class="h2">Portal do Aluno</h1>

    <div class="card border-left-3 border-left-primary card-2by1">
        <div class="card-body">
            <div class="media flex-wrap align-items-center">
                <div class="media-left">
                    <i class="material-icons text-muted-light">star</i>
                </div>
                <div class="media-body" style="min-width: 180px">
                    Você acaba de receber a sua primeira conquista! <strong>Você preencheu todos os seus dados corretamente.</strong>
                </div>
                <div class="media-right mt-2 mt-xs-plus-0">
                    <a class="btn btn-success" href="student-account-billing-upgrade.html">Pegar Conquista</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7">

            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <div class="h2 mb-0 mr-3 text-primary">116</div>
                    <div class="flex">
                        <h4 class="card-title">Informática</h4>
                        <p class="card-subtitle">Maior conhecimento</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart" style="height: 319px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="topicIqChart" class="chart-canvas js-update-chart-line chartjs-render-monitor" data-chart-hide-axes="false" data-chart-points="true" data-chart-suffix=" points" data-chart-line-border-color="primary" width="596" height="398" style="display: block; height: 319px; width: 477px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <h4 class="card-title">Cursos</h4>
                            <p class="card-subtitle">Cursos recentes</p>
                        </div>
                        <div class="media-right">
                            <a class="btn btn-sm btn-primary" href="student-my-courses.html">Ver todos os cursos</a>
                        </div>
                    </div>
                </div>

                <ul class="list-group list-group-fit mb-0" style="z-index: initial;">

                    <li class="list-group-item" style="z-index: initial;">
                        <div class="d-flex align-items-center">
                            <div class="flex">
                                <a href="{{ route('ver') }}" class="text-body"><strong>Windows</strong></a>
                                <div class="d-flex align-items-center">
                                    <div class="progress" style="width: 100px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small class="text-muted ml-2">25%</small>
                                </div>
                            </div>
                            <div class="dropdown ml-3">
                                <a href="#" class="dropdown-toggle text-muted" data-caret="false" data-toggle="dropdown">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('ver') }}">Continuar</a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item" style="z-index: initial;">
                        <div class="d-flex align-items-center">
                            {{-- <a href="{{ route('ver') }}" class="avatar avatar-4by3 avatar-sm mr-3">
                                <img src="assets/images/vuejs.png" alt="course" class="avatar-img rounded">
                            </a> --}}
                            <div class="flex">
                                <a href="{{ route('ver') }}" class="text-body"><strong>Segurança Digital</strong></a>
                                <div class="d-flex align-items-center">
                                    <div class="progress" style="width: 100px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small class="text-muted ml-2">100%</small>
                                </div>
                            </div>
                            <div class="dropdown ml-3">
                                <a href="#" class="dropdown-toggle text-muted" data-caret="false" data-toggle="dropdown">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('ver') }}">Rever</a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item" style="z-index: initial;">
                        <div class="d-flex align-items-center">
                            <div class="flex">
                                <a href="{{ route('ver') }}" class="text-body"><strong>Office</strong></a>
                                <div class="d-flex align-items-center">
                                    <div class="progress" style="width: 100px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small class="text-muted ml-2">80%</small>
                                </div>
                            </div>
                            <div class="dropdown ml-3">
                                <a href="#" class="dropdown-toggle text-muted" data-caret="false" data-toggle="dropdown">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('ver') }}">Continuar</a>
                                </div>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <h4 class="card-title">Últimas aulas</h4>
                            <p class="card-subtitle">Acompanhe a sua performance</p>
                        </div>
                        <div class="media-right">
                            <a class="btn btn-sm btn-primary" href="#">Ver todas as aulas feitas</a>
                        </div>
                    </div>
                </div>

                <ul class="list-group list-group-fit mb-0">

                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <div class="media-body">
                                <a class="text-body" href="student-quiz-results.html"><strong>Titulo da Aula</strong></a><br>
                                <div class="d-flex align-items-center">
                                    <small class="text-black-50 text-uppercase mr-2">Curso</small>
                                    <a href="{{ route('ver') }}">Nome do Curso</a>
                                </div>
                            </div>
                            <div class="media-right text-center d-flex align-items-center">
                                <span class="text-black-50 mr-3">Bom</span>
                                <h4 class="mb-0">6.8</h4>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <div class="media-body">
                                <a class="text-body" href="student-quiz-results.html"><strong>Titulo da Aula</strong></a><br>
                                <div class="d-flex align-items-center">
                                    <small class="text-black-50 text-uppercase mr-2">Curso</small>
                                    <a href="{{ route('ver') }}">Nome do Curso</a>
                                </div>
                            </div>
                            <div class="media-right text-center d-flex align-items-center">
                                <span class="text-black-50 mr-3">Parabéns!</span>
                                <h4 class="mb-0 text-success">9.8</h4>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <div class="media-body">
                                <a class="text-body" href="student-quiz-results.html"><strong>Titulo da Aula</strong></a><br>
                                <div class="d-flex align-items-center">
                                    <small class="text-black-50 text-uppercase mr-2">Curso</small>
                                    <a href="{{ route('ver') }}">Nome do Curso</a>
                                </div>
                            </div>
                            <div class="media-right text-center d-flex align-items-center">
                                <span class="text-black-50 mr-3">Tente novamente</span>
                                <h4 class="mb-0 text-danger">2.8</h4>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
        <div class="col-lg-5">

            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <div class="h2 mb-0 mr-3 text-primary">432</div>
                    <div class="flex">
                        <h4 class="card-title">Seu Crescimento</h4>
                        <p class="card-subtitle">4 dias consecutivos esta semana</p>
                    </div>
                    <i class="material-icons text-muted ml-2">trending_up</i>
                </div>
                <div class="card-body">
                    <div class="chart" style="height: 154px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="iqChart" class="chart-canvas js-update-chart-line chartjs-render-monitor" data-chart-points="true" data-chart-suffix="pt" data-chart-line-border-color="primary" style="display: block; height: 154px; width: 323px;" width="403" height="192"></canvas>
                    </div>
                </div>
            </div>

            <div class="card card-2by1">
                <div class="card-header">
                    <h4 class="card-title">Conquistas</h4>
                    <p class="card-subtitle">Suas principais conquistas!</p>
                </div>
                <div class="card-body text-center">
                    <div class="btn btn-primary btn-circle"><i class="material-icons">thumb_up</i></div>
                    <div class="btn btn-danger btn-circle"><i class="material-icons">grade</i></div>
                    <div class="btn btn-success btn-circle"><i class="material-icons">bubble_chart</i></div>
                    <div class="btn btn-warning btn-circle"><i class="material-icons">keyboard_voice</i></div>
                    <div class="btn btn-info btn-circle"><i class="material-icons">event_available</i></div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <h4 class="card-title">Chamados</h4>
                            <p class="card-subtitle">Chamados recentes</p>
                        </div>
                        <div class="media-right">
                            <a class="btn btn-sm btn-primary" href="student-forum.html"> <i class="material-icons">keyboard_arrow_right</i></a>
                        </div>
                    </div>
                </div>

                <ul class="list-group list-group-fit">

                    <li class="list-group-item forum-thread">
                        <div class="media align-items-center">
                            <div class="media-left">
                                <div class="forum-icon-wrapper">
                                    <a href="student-forum-thread.html" class="forum-thread-icon">
                                        <i class="material-icons">description</i>
                                    </a>
                                    <a href="student-profile.html" class="forum-thread-user">
                                        <img src="assets/images/people/50/guy-1.jpg" alt="" width="20" class="rounded-circle">
                                    </a>
                                </div>
                            </div>
                            <div class="media-body">
                                <div class="d-flex align-items-center">
                                    <a href="student-profile.html" class="text-body"><strong>Windows</strong></a>
                                    <small class="ml-auto text-muted">Há 20min</small>
                                </div>
                                <a class="text-black-70" href="student-forum-thread.html">É possível ter duas contas de usuário?</a>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item forum-thread">
                        <div class="media align-items-center">
                            <div class="media-left">
                                <div class="forum-icon-wrapper">
                                    <a href="student-forum-thread.html" class="forum-thread-icon">
                                        <i class="material-icons">description</i>
                                    </a>
                                    <a href="student-profile.html" class="forum-thread-user">
                                        <img src="assets/images/people/50/guy-2.jpg" alt="" width="20" class="rounded-circle">
                                    </a>
                                </div>
                            </div>
                            <div class="media-body">
                                <div class="d-flex align-items-center">
                                    <a href="student-profile.html" class="text-body"><strong>Office</strong></a>
                                    <small class="ml-auto text-muted">1 dia atrás</small>
                                </div>
                                <a class="text-black-70" href="student-forum-thread.html">Como salvo um arquivo word em pdf?</a>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item forum-thread">
                        <div class="media align-items-center">
                            <div class="media-left">
                                <div class="forum-icon-wrapper">
                                    <a href="student-forum-thread.html" class="forum-thread-icon">
                                        <i class="material-icons">description</i>
                                    </a>
                                    <a href="student-profile.html" class="forum-thread-user">
                                        <img src="assets/images/people/50/woman-1.jpg" alt="" width="20" class="rounded-circle">
                                    </a>
                                </div>
                            </div>
                            <div class="media-body">
                                <div class="d-flex align-items-center">
                                    <a href="student-profile.html" class="text-body"><strong>Windows</strong></a>
                                    <small class="ml-auto text-muted">2 dias atrás</small>
                                </div>
                                <a class="text-black-70" href="student-forum-thread.html">Tem como colocar senha no computador?</a>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>

@endsection
