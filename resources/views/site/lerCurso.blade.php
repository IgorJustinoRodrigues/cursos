@extends('template.site')
@section('title', 'Ler Curso')

@section('header')

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
                        <img src="{{ URL::asset('site/images/pageheader/02.jpg') }}" alt="rajibraj91"
                            class="w-100">
                        <a href="https://www.youtube-nocookie.com/embed/jP649ZHA8Tg" class="video-button"
                            data-rel="lightcase"><i class="icofont-ui-play"></i></a>
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
                            <div class="course-reiew">
                                <span class="ratting">
                                    <i class="icofont-ui-rating"></i>
                                    <i class="icofont-ui-rating"></i>
                                    <i class="icofont-ui-rating"></i>
                                    <i class="icofont-ui-rating"></i>
                                    <i class="icofont-ui-rating"></i>
                                </span>
                                <span class="ratting-count">
                                    03 reviews
                                </span>
                            </div>
                        </div>
                        @if (isset($_SESSION['ativacao_start']) and $_SESSION['ativacao_start']['matricula']->id != null)
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
    <div class="course-single-section padding-tb section-bg">
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
                            <div class="course-video-title">
                                <h4>Conteúdo do curso</h4>
                            </div>
                            <div class="course-video-content">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <div class="accordion-header" id="accordion01">
                                            <button class="d-flex flex-wrap justify-content-between"
                                                data-bs-toggle="collapse" data-bs-target="#videolist1" aria-expanded="true"
                                                aria-controls="videolist1"><span>1.Contéudo de Prévia do Curso</span>
                                                <span>{{ $quantidadeAula }} Aulas,
                                                    {{ app(App\Services\Services::class)->minuto_hora($tempoTotal) }}</span>
                                            </button>
                                        </div>
                                        <div id="videolist1" class="accordion-collapse collapse show"
                                            aria-labelledby="accordion01" data-bs-parent="#accordionExample">
                                            <ul class="lab-ul video-item-list">
                                                @foreach ($aulas as $linha)
                                                    <li class=" d-flex flex-wrap justify-content-between">
                                                        <div class="video-item-title">{{ $linha->nome }}</div>
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

                        <div id="respond" class="comment-respond mb-lg-0">
                            <h4 class="title-border">Pedir mais detalhes do Curso de {{ $curso->nome }}</h4>
                            <div class="add-comment">
                                <form action="#" method="post" id="commentform" class="comment-form">
                                    <input type="text" placeholder="review title">
                                    <input type="text" placeholder="reviewer name">
                                    <input type="email" placeholder="reviewer email">
                                    <textarea rows="5" placeholder="review summary"></textarea>
                                    <button type="submit" class="lab-btn"><span>Submit Review</span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar-part">
                        <div class="course-side-detail">
                            <div class="csd-title">
                                <div class="csdt-left">
                                    <h4 class="mb-0"><sup>$</sup>38</h4>
                                </div>
                                <div class="csdt-right">
                                    <p class="mb-0"><i class="icofont-clock-time"></i>Limited time offer</p>
                                </div>
                            </div>
                            <div class="csd-content">
                                <div class="csdc-lists">
                                    <ul class="lab-ul">
                                        <li>
                                            <div class="csdc-left"><i class="icofont-ui-alarm"></i>Nível do curso</div>
                                            <div class="csdc-right">
                                                {{ app(App\Http\Controllers\CursoController::class)->tipo($curso->tipo, true) }}
                                            </div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><i class="icofont-book-alt"></i>Duração do curso
                                            </div>
                                            <div class="csdc-right">
                                                {{ app(App\Services\Services::class)->minuto_hora($tempoTotal) }}</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><i class="icofont-video-alt"></i>Lições</div>
                                            <div class="csdc-right">{{ $quantidadeAula }}x</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><i class="icofont-abacus-alt"></i>Quizzes</div>
                                            <div class="csdc-right">{{ $totalQuiz }}</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><i class="icofont-hour-glass"></i>Porcentagem de
                                                Aprovação
                                            </div>
                                            <div class="csdc-right">
                                                {{ $curso->porcentagem_solicitacao_certificado }}%</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><i class="icofont-certificate"></i>Certificado
                                            </div>
                                            <div class="csdc-right">sim</div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="sidebar-social">
                                    <div class="ss-title">
                                        <h6>Share This Course:</h6>
                                    </div>
                                    <div class="ss-content">
                                        <ul class="lab-ul">
                                            <li><a href="#" class="twitter"><i class="icofont-twitter"></i></a>
                                            </li>
                                            <li><a href="#" class="vimeo"><i class="icofont-vimeo"></i></a></li>
                                            <li><a href="#" class="rss"><i class="icofont-rss"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="course-enroll">
                                    <a href="#" class="lab-btn"><span>Enrolled Now</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="course-side-cetagory">
                            <div class="csc-title">
                                <h5 class="mb-0">Course Categories</h5>
                            </div>
                            <div class="csc-content">
                                <div class="csdc-lists">
                                    <ul class="lab-ul">
                                        <li>
                                            <div class="csdc-left"><a href="#">Personal Development</a></div>
                                            <div class="csdc-right">30</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><a href="#">Photography</a></div>
                                            <div class="csdc-right">20</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><a href="#">Teaching and Academics</a></div>
                                            <div class="csdc-right">93</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><a href="#">Art and Design</a></div>
                                            <div class="csdc-right">32</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><a href="#">Business</a></div>
                                            <div class="csdc-right">26</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><a href="#">Data Science</a></div>
                                            <div class="csdc-right">27</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><a href="#">Development</a></div>
                                            <div class="csdc-right">28</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><a href="#">Finance</a></div>
                                            <div class="csdc-right">36</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><a href="#">Health & Fitness</a></div>
                                            <div class="csdc-right">39</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><a href="#">Lifestyle</a></div>
                                            <div class="csdc-right">37</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><a href="#">Marketing</a></div>
                                            <div class="csdc-right">18</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><a href="#">Music</a></div>
                                            <div class="csdc-right">20</div>
                                        </li>
                                    </ul>
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
