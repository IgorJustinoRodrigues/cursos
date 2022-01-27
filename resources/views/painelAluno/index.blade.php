@extends('template.aluno')
@section('title', 'Painel de aluno')

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
    <script src="{{ URL::asset('template/js/page.student-dashboard.js') }}"></script>

    <script>
        var data = {
            labels: ["JavaScript", "HTML", "Flinto", "Vue.js", "Sketch", "Priciple", "CSS", "Angular"],
            datasets: [{
                label: "Experience IQ",
                data: [30, 35, 33, 32, 31, 10, 28, 36],
                pointHoverBorderColor: settings.colors.success[400],
                pointHoverBackgroundColor: settings.colors.white,
                borderJoinStyle: 'bevel',
                lineTension: .1
            }]
        }
        Charts.create('#topicIqChart', 'radar', '', data)


        var data = {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Performance",
                data: [0, 10, 5, 15, 10, 20, 15, 25, 20, 30, 25, 40]
            }]
        }

        Charts.create('#performanceChart', 'line', '', data)
    </script>

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
                    Olá {{ $_SESSION['aluno_cursos_start']->nome }}
                    Você acaba de receber a sua primeira conquista! <strong>Você preencheu todos os seus dados
                        corretamente.</strong>
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
                    <div class="chart">
                        <canvas id="topicIqChart" class="chart-canvas" data-chart-suffix=" points"
                            data-chart-line-border-color="primary"></canvas>
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
                            <a class="btn btn-sm btn-primary" href="{{ route('alunoCursos') }}">Ver todos os cursos</a>
                        </div>
                    </div>
                </div>

                <ul class="list-group list-group-fit mb-0" style="z-index: initial;">

                    @foreach ($meusCursos as $linha)
                        <li class="list-group-item" style="z-index: initial; background-color: #f6f6f6;">
                            <div class="d-flex align-items-center">
                                <div class="flex">
                                    <a href="" class="text-body"><strong>{{ $linha->nome }}</strong></a>
                                    <div class="d-flex align-items-center">
                                        <div class="progress" style="width: {{ $linha->porcentagem }}px;">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ $linha->porcentagem }}%" aria-valuenow="00"
                                                aria-valuemin="0" aria-valuemax="{{ $linha->porcentagem }}"></div>
                                        </div>
                                        <small class="text-muted ml-2">{{ $linha->porcentagem }}%&nbsp;</small>
                                    </div>
                                    <small class="text-muted">Aulas concluidas: {{ $linha->total_aula_concluido }} de
                                        {{ $linha->total_aula }}</small>
                            </div>
                                <div class="dropdown ml-3">
                                    <a href="#" class="dropdown-toggle text-muted" data-caret="false"
                                        data-toggle="dropdown">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @if ($linha->porcentagem == 100)
                                            <a href="{{ route('verAulas', [$linha->id, Str::slug($linha->nome, '-') . '.html']) }}"
                                                class="dropdown-item">Rever Aulas <i
                                                    class="material-icons btn__icon--right">autorenew</i></a>

                                            <a href="{{ route('verAulas', [$linha->id, Str::slug($linha->nome, '-') . '.html']) }}"
                                                class="dropdown-item">Certificado <i
                                                    class="material-icons btn__icon--right">beenhere</i></a>
                                        @else
                                            <a href="{{ route('verAulas', [$linha->id, Str::slug($linha->nome, '-') . '.html']) }}"
                                                class="dropdown-item" >Acessar Aulas <i
                                                    class="material-icons btn__icon--right">play_circle_outline</i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach

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
                    @foreach ($ultimasAulas as $linha)
                        <li class="list-group-item">
                            <div class="media align-items-center">
                                <div class="media-body">
                                    <a class="text-body"
                                        href="{{ route('aula', [$linha->curso_id, Str::slug($linha->curso, '-'), $linha->aula_id, Str::slug($linha->aula, '-') . '.html']) }}">
                                        <strong>{!! app(App\Http\Controllers\AulaController::class)->tipo($linha->tipo, $linha->avaliacao, true) !!}{{ $linha->aula }}</strong></a>
                                        <br>
                                    <div class="d-flex align-items-center">
                                        <small class="text-black-50 text-uppercase mr-2">Curso</small>
                                        <a href="{{ route('verAulas', [$linha->curso_id, Str::slug($linha->curso, '-') . '.html']) }}">{{ $linha->curso }}</a>
                                    </div>
                                </div>
                                <div class="media-right text-center d-flex align-items-center">
                                    @if($linha->conclusao != null)
                                    <span
                                        class="text-black-50 mr-3">{{ app(App\Http\Controllers\AulaController::class)->msgNota($linha->nota) }}</span>
                                    <h4 class="mb-0">{{ $linha->nota }}%</h4>
                                    @else
                                    <span
                                        class="text-black-50 mr-3">Aula iniciada em {{ $linha->created_at->format('d/m') }} às {{ $linha->created_at->format('H:i') }}</span>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
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
                    <div class="chart">
                        <canvas id="performanceChart" class="chart-canvas" data-chart-prefix=""
                            data-chart-suffix="k"></canvas>
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
                            <a class="btn btn-sm btn-primary" href="student-forum.html"> <i
                                    class="material-icons">keyboard_arrow_right</i></a>
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
                                        <img src="assets/images/people/50/guy-1.jpg" alt="" width="20"
                                            class="rounded-circle">
                                    </a>
                                </div>
                            </div>
                            <div class="media-body">
                                <div class="d-flex align-items-center">
                                    <a href="student-profile.html" class="text-body"><strong>Windows</strong></a>
                                    <small class="ml-auto text-muted">Há 20min</small>
                                </div>
                                <a class="text-black-70" href="student-forum-thread.html">É possível ter duas contas de
                                    usuário?</a>
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
                                        <img src="assets/images/people/50/guy-2.jpg" alt="" width="20"
                                            class="rounded-circle">
                                    </a>
                                </div>
                            </div>
                            <div class="media-body">
                                <div class="d-flex align-items-center">
                                    <a href="student-profile.html" class="text-body"><strong>Office</strong></a>
                                    <small class="ml-auto text-muted">1 dia atrás</small>
                                </div>
                                <a class="text-black-70" href="student-forum-thread.html">Como salvo um arquivo word em
                                    pdf?</a>
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
                                        <img src="assets/images/people/50/woman-1.jpg" alt="" width="20"
                                            class="rounded-circle">
                                    </a>
                                </div>
                            </div>
                            <div class="media-body">
                                <div class="d-flex align-items-center">
                                    <a href="student-profile.html" class="text-body"><strong>Windows</strong></a>
                                    <small class="ml-auto text-muted">2 dias atrás</small>
                                </div>
                                <a class="text-black-70" href="student-forum-thread.html">Tem como colocar senha no
                                    computador?</a>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>

@endsection
