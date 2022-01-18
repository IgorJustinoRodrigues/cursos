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
                            <a href="#" class="course-cate">Adobe XD</a>
                            <a href="#" class="course-offer">30% de Desconto</a>
                        </div>
                        <h2 class="phs-title">{{ $lerCurso->nome }}</h2>
                        <p class="phs-desc"></p>
                        <div class="phs-thumb">
                            <img src="{{ URL::asset('site/images/pageheader/03.jpg') }}" alt="rajibraj91">
                            <span>{{ $lerCurso->professor }}</span>
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
                                    <p>{!! $lerCurso->descricao !!}</p>

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
                                                aria-controls="videolist1"><span>1.Contéudo de Prévia do Curso</span> <span>{{$lerCurso->soma}} Aulas,
                                                    17:37</span> </button>
                                        </div>
                                        <div id="videolist1" class="accordion-collapse collapse show"
                                            aria-labelledby="accordion01" data-bs-parent="#accordionExample">
                                            <ul class="lab-ul video-item-list">
                                                <li class=" d-flex flex-wrap justify-content-between">
                                                    <div class="video-item-title">Ver Prévia do Curso</div>
                                                    <div class="video-item-icon"><a
                                                            href="https://player.vimeo.com/video/388311362"
                                                            data-rel="lightcase"><i class="icofont-play-alt-2"></i></a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="respond" class="comment-respond mb-lg-0">
                            <h4 class="title-border">Pedir mais detalhes do Curso de {{$lerCurso->nome}}</h4>
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
                                            <div class="csdc-left"><i class="icofont-ui-alarm"></i>Course level</div>
                                            <div class="csdc-right">Beginner</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><i class="icofont-book-alt"></i>Course Duration
                                            </div>
                                            <div class="csdc-right">10 week</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><i class="icofont-signal"></i>Online Class</div>
                                            <div class="csdc-right">08</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><i class="icofont-video-alt"></i>Lessions</div>
                                            <div class="csdc-right">18x</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><i class="icofont-abacus-alt"></i>Quizzes</div>
                                            <div class="csdc-right">0</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><i class="icofont-hour-glass"></i>Pass parcentages
                                            </div>
                                            <div class="csdc-right">80</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><i class="icofont-certificate"></i>Certificate
                                            </div>
                                            <div class="csdc-right">Yes</div>
                                        </li>
                                        <li>
                                            <div class="csdc-left"><i class="icofont-globe"></i>Language</div>
                                            <div class="csdc-right">English</div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="sidebar-payment">
                                    <div class="sp-title">
                                        <h6>Secure Payment:</h6>
                                    </div>
                                    <div class="sp-thumb">
                                        <img src="assets/images/pyment/01.jpg" alt="CodexCoder">
                                    </div>
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
