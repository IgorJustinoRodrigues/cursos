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
            labels: [
                @for ($i = 6; $i >= 0; $i--)
                    "{{ Carbon\Carbon::now()->subDays($i)->format('d/m') }}",
                @endfor
            ],
            datasets: [{
                label: "Performance",
                data: [
                    @for ($i = 6; $i >= 0; $i--)
                        @php $aux = false; @endphp
                    
                        @foreach ($grafico7dias as $dia)
                            @if ($dia->conclusao->format('d') === Carbon\Carbon::now()->subDays($i)->format('d'))
                                {{ $dia->total }},
                                @php $aux = true; @endphp
                                @php break; @endphp
                            @endif
                        @endforeach

                        @if(!$aux)
                            0,  
                        @endif
                    @endfor

                ]
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
                                                class="dropdown-item">Acessar Aulas <i
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
                            <a class="btn btn-sm btn-primary" href="{{ route('aulasFeitas') }}">Ver todas as aulas
                                feitas</a>
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
                                        <a
                                            href="{{ route('verAulas', [$linha->curso_id, Str::slug($linha->curso, '-') . '.html']) }}">{{ $linha->curso }}</a>
                                    </div>
                                </div>
                                <div class="media-right text-center d-flex align-items-center">
                                    @if ($linha->conclusao != null)
                                        <span
                                            class="text-black-50 mr-3">{{ app(App\Http\Controllers\AulaController::class)->msgNota($linha->nota) }}</span>
                                        <h4 class="mb-0">{{ $linha->nota }}%</h4>
                                    @else
                                        <span class="text-black-50 mr-3">Aula iniciada em
                                            {{ $linha->created_at->format('d/m') }} às
                                            {{ $linha->created_at->format('H:i') }}</span>
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
                    <div class="flex">
                        <h4 class="card-title">Seu Crescimento</h4>
                        <p class="card-subtitle">Aulas concluidas nos últimos 7 dias</p>
                    </div>
                    <i class="material-icons text-muted ml-2">trending_up</i>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="performanceChart" class="chart-canvas" data-chart-prefix=""
                            data-chart-suffix=""></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
