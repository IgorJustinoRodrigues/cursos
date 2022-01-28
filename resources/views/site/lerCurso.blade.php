@extends('template.site')
@section('title', $curso->nome)

@section('header')
    <style>
        .dourado {
            color: #ffd400 !important;
        }

        .prata {
            color: #f2f1ea !important;
        }

    </style>
@endsection

@section('footer')

@endsection

@section('conteudo')

    <!-- Page Header section start here -->
    <div class="pageheader-section style-2">
        <div class="container">
            <div class="row justify-content-center justify-content-lg-between align-items-center flex-row-reverse">
                <div class="col-lg-7 col-12">
                    <div class="pageheader-thumb">

                        @if ($curso->imagem != '')
                            <img src="{{ URL::asset('storage/' . $curso->imagem) }}" alt="rajibraj91"
                                class="w-100">
                        @else
                            <img src="{{ URL::asset('storage/imagemCurso/padrao.png') }}" alt="rajibraj91"
                                class="w-100">
                        @endif
                    </div>
                </div>
                <div class="col-lg-5 col-12">
                    <div class="pageheader-content">
                        <div class="course-category">
                            <a href="#" class="course-cate">{{ $categoria->nome }}</a>
                            <a href="#"
                                class="course-offer">{{ app(App\Http\Controllers\CursoController::class)->tipo($curso->tipo, true) }}</a>
                        </div>
                        <h2 class="phs-title">{{ $curso->nome }}</h2>
                        <p class="phs-desc"></p>
                        <div class="phs-thumb">
                            @if ($professor->avatar != '')
                                <img src="{{ URL::asset('storage/' . $professor->avatar) }}" class="avatar-img">
                            @else
                                <img src="{{ URL::asset('storage/avatarProfessor/padrao.png') }}" style="width: 50px">
                            @endif
                            <span>{{ $professor->nome }}</span>
                            <br>
                            <div class="course-reiew">
                                <span class="ratting">
                                    @for ($i = 1; $i < 6; $i++)
                                        @if ($i <= $curso->estrelas)
                                            <i class="icofont-ui-rating dourado"></i>
                                        @else
                                            <i class="icofont-ui-rating prata"></i>
                                        @endif
                                    @endfor
                                </span>
                                <span class="ratting-count">
                                    {{ $curso->alunos }} aluno matrículados
                                </span>
                            </div>
                        </div>
                        @php session_start(); @endphp
                        @if (isset($_SESSION['ativacao_start']))
                            <p class="phs-desc"></p>
                            <form action="{{ route('site.escolhaCurso') }}" method="post" class="phs-thumb">
                                @csrf
                                <input type="hidden" name="curso_id" value="{{ $curso->id }}">
                                <button class="lab-btn bg-success"><span>FAZER ESSE CURSO!</span></button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header section ending here -->


    <!-- course section start here -->
    <div class="course-single-section padding-tb section-bg" style="background: #f8f8f8 !important">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="main-part">
                        <div class="course-item">
                            <div class="course-inner">
                                <div class="course-content">
                                    <h3>Visão geral do curso</h3>
                                    <!-- Descrição do Ler Curso -->
                                    <p>{!! $curso->descricao !!}</p>

                                </div>
                            </div>
                        </div>

                        <div class="course-video">
                            <div class="course-video-content">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <div class="accordion-header" id="accordion01">
                                            <button class="d-flex flex-wrap justify-content-between"
                                                data-bs-toggle="collapse" data-bs-target="#videolist1" aria-expanded="true"
                                                aria-controls="videolist1"><span>Contéudo Programático</span>
                                                <span>{{ $quantidadeAula }} Aulas,
                                                    {{ app(App\Services\Services::class)->minuto_hora($tempoTotal) }}</span>
                                            </button>
                                        </div>
                                        <div id="videolist1" class="accordion-collapse collapse show"
                                            aria-labelledby="accordion01" data-bs-parent="#accordionExample">
                                            <ul class="lab-ul video-item-list">
                                                @foreach ($aulas as $linha)
                                                    <li class=" d-flex flex-wrap justify-content-between">
                                                        <div class="video-item-title">
                                                            {!! app(App\Http\Controllers\AulaController::class)->tipo($linha->tipo, $linha->avaliacao) !!} |
                                                            {{ $linha->nome }}</div>
                                                        <div class="video-item-icon">
                                                            {{ app(App\Services\Services::class)->minuto_hora($linha->duracao) }}
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="course-side-detail">
                        <div class="csd-content">
                            <div class="row">
                                <a class="btn btn-outline-success btn-lg btn-block" href="{{ route('site.aulaTeste', [$curso->id, Str::slug($curso->nome)]) }}"><span>VER AULA TESTE!</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-part">
                        <div class="course-side-detail">
                            <div class="csd-title">
                                <div class="csdt-right">
                                    <p class="mb-0"><i class="icofont-attachment"></i>Informações Técnicas</p>
                                </div>
                            </div>
                            <div class="csd-content">
                                <div class="csdc-lists">
                                    <ul class="lab-ul">
                                        <li>
                                            <div class="csdc-left"><i class="icofont-fire"></i>Nível do curso</div>
                                            <div class="csdc-right">
                                                {{ app(App\Http\Controllers\CursoController::class)->tipo($curso->tipo, true) }}
                                            </div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><i class="icofont-clock-time"></i>Duração do curso
                                            </div>
                                            <div class="csdc-right">
                                                {{ app(App\Services\Services::class)->minuto_hora($tempoTotal) }}</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><i class="icofont-video-alt"></i>Lições</div>
                                            <div class="csdc-right">{{ $quantidadeAula }}x</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><i class="icofont-listine-dots"></i>Quizzes</div>
                                            <div class="csdc-right">{{ $totalQuiz }}</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><i class="icofont-certificate-alt-1"></i>Certificado
                                            </div>
                                            <div class="csdc-right">sim</div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="sidebar-social text-center">
                                    <span class="ratting">
                                        @for ($i = 1; $i < 6; $i++)
                                            @if ($i <= $curso->estrelas)
                                                <i class="icofont-ui-rating dourado"></i>
                                            @else
                                                <i class="icofont-ui-rating prata"></i>
                                            @endif
                                        @endfor
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- course section ending here -->
@endsection
