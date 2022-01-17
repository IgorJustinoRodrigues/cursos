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
                        <h2 class="phs-title">{{$lerCurso->nome }}</h2>
                        <p class="phs-desc"></p>
                        <div class="phs-thumb">
                            <img src="{{ URL::asset('site/images/pageheader/03.jpg') }}" alt="rajibraj91">
                            <span>{{$lerCurso->professor}}</span>
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
                                    <p>{!! $lerCurso->descricao !!}</p>
                                    <h4>O que você vai aprender neste curso:</h4>
                                    <ul class="lab-ul">
                                        <li><i class="icofont-tick-mark"></i>Pronto para começar a trabalhar em projetos de
                                            modelagem de dados do mundo real</li>
                                        <li><i class="icofont-tick-mark"></i>Responsabilidades expandidas como parte de uma
                                            função existente</li>
                                        <li><i class="icofont-tick-mark"></i>Ser capaz de criar Flyers, Brochuras, Anúncios
                                        </li>
                                        <li><i class="icofont-tick-mark"></i>Encontre uma nova posição envolvendo modelagem
                                            de dados.</li>
                                        <li><i class="icofont-tick-mark"></i>Trabalhar com cores e gradientes e grades</li>
                                    </ul>
                                    <p>Neste curso, você aprenderá desde os fundamentos e conceitos de modelagem de dados
                                        até várias práticas e técnicas recomendadas necessárias para criar modelos de dados
                                        em sua organização. Você encontrará muitos exemplos que claramente a chave cobriu o
                                        curso</p>
                                    <p>Ao final do curso, você estará pronto para não apenas colocar esses princípios em
                                        prática, mas também para tomar as principais decisões de modelagem de dados e design
                                        exigidas pela modelagem de dados de informações que transcendem os detalhes básicos
                                        que claramente são a chave cobriu o curso e os padrões de projeto.</p>
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
                                                aria-controls="videolist1"><span>1.Introdução</span> <span>5 Aulas,
                                                    17:37</span> </button>
                                        </div>
                                        <div id="videolist1" class="accordion-collapse collapse show"
                                            aria-labelledby="accordion01" data-bs-parent="#accordionExample">
                                            <ul class="lab-ul video-item-list">
                                                <li class=" d-flex flex-wrap justify-content-between">
                                                    <div class="video-item-title">1.1 Bem-vindo ao curso 02:30 minutos</div>
                                                    <div class="video-item-icon"><a
                                                            href="https://www.youtube-nocookie.com/embed/jP649ZHA8Tg"
                                                            data-rel="lightcase"><i class="icofont-play-alt-2"></i></a>
                                                    </div>
                                                </li>
                                                <li class=" d-flex flex-wrap justify-content-between">
                                                    <div class="video-item-title">1.2 Como configurar seu espaço de trabalho
                                                        do photoshop 08:33 minutos</div>
                                                    <div class="video-item-icon"><a
                                                            href="https://www.youtube-nocookie.com/embed/jP649ZHA8Tg"
                                                            data-rel="lightcase"><i class="icofont-play-alt-2"></i></a>
                                                    </div>
                                                </li>
                                                <li class=" d-flex flex-wrap justify-content-between">
                                                    <div class="video-item-title">1.3 Ferramentas essenciais do Photoshop
                                                        03:38 minutos</div>
                                                    <div class="video-item-icon"><a
                                                            href="https://www.youtube-nocookie.com/embed/jP649ZHA8Tg"
                                                            data-rel="lightcase"><i class="icofont-play-alt-2"></i></a>
                                                    </div>
                                                </li>
                                                <li class=" d-flex flex-wrap justify-content-between">
                                                    <div class="video-item-title">1.4 Encontrando inspiração 02:30 minutos
                                                    </div>
                                                    <div class="video-item-icon"><a
                                                            href="https://www.youtube-nocookie.com/embed/jP649ZHA8Tg"
                                                            data-rel="lightcase"><i class="icofont-play-alt-2"></i></a>
                                                    </div>
                                                </li>
                                                <li class=" d-flex flex-wrap justify-content-between">
                                                    <div class="video-item-title">1.5 Escolhendo seu formato 03:48 minutos
                                                    </div>
                                                    <div class="video-item-icon"><a
                                                            href="https://www.youtube-nocookie.com/embed/jP649ZHA8Tg"
                                                            data-rel="lightcase"><i class="icofont-play-alt-2"></i></a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <div class="accordion-header" id="accordion02">
                                            <button class="d-flex flex-wrap justify-content-between"
                                                data-bs-toggle="collapse" data-bs-target="#videolist2" aria-expanded="true"
                                                aria-controls="videolist2"> <span>2.Como criar arte de mídia mista no Adobe
                                                    Photoshop</span> <span>5 Aulas, 52:15</span> </button>
                                        </div>
                                        <div id="videolist2" class="accordion-collapse collapse"
                                            aria-labelledby="accordion02" data-bs-parent="#accordionExample">
                                            <ul class="lab-ul video-item-list">
                                                <li class=" d-flex flex-wrap justify-content-between">
                                                    <div class="video-item-title">2.1 Usando Camadas de Ajuste 06:20 minutos
                                                    </div>
                                                    <div class="video-item-icon"><a
                                                            href="https://www.youtube-nocookie.com/embed/jP649ZHA8Tg"
                                                            data-rel="lightcase"><i class="icofont-play-alt-2"></i></a>
                                                    </div>
                                                </li>
                                                <li class=" d-flex flex-wrap justify-content-between">
                                                    <div class="video-item-title">2.2 Construindo a composição 07:33 minutos
                                                    </div>
                                                    <div class="video-item-icon"><a
                                                            href="https://www.youtube-nocookie.com/embed/jP649ZHA8Tg"
                                                            data-rel="lightcase"><i class="icofont-play-alt-2"></i></a>
                                                    </div>
                                                </li>
                                                <li class=" d-flex flex-wrap justify-content-between">
                                                    <div class="video-item-title">2.3 Efeitos de iluminação do Photoshop
                                                        06:30 minutos</div>
                                                    <div class="video-item-icon"><a
                                                            href="https://www.youtube-nocookie.com/embed/jP649ZHA8Tg"
                                                            data-rel="lightcase"><i class="icofont-play-alt-2"></i></a>
                                                    </div>
                                                </li>
                                                <li class=" d-flex flex-wrap justify-content-between">
                                                    <div class="video-item-title">2.4 Pintura digital usando pincéis do
                                                        photoshop 08:34 minutos</div>
                                                    <div class="video-item-icon"><a
                                                            href="https://www.youtube-nocookie.com/embed/jP649ZHA8Tg"
                                                            data-rel="lightcase"><i class="icofont-play-alt-2"></i></a>
                                                    </div>
                                                </li>
                                                <li class=" d-flex flex-wrap justify-content-between">
                                                    <div class="video-item-title">2.5 Finalizando os detalhes 10:30 minutos
                                                    </div>
                                                    <div class="video-item-icon"><a
                                                            href="https://www.youtube-nocookie.com/embed/jP649ZHA8Tg"
                                                            data-rel="lightcase"><i class="icofont-play-alt-2"></i></a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="authors">
                            <div class="author-thumb">
                                <img src="assets/images/author/01.jpg" alt="rajibraj91">
                            </div>
                            <div class="author-content">
                                <h5>Geraldine S. Roemer</h5>
                                <span>Assistant Teacher</span>
                                <p>I'm an Afro-Latina digital artist originally from Long Island, NY. I love to paint design
                                    and photo manpulate in Adobe Photoshop while helping others learn too. Follow me on
                                    Instagram or tweet me</p>
                                <ul class="lab-ul social-icons">
                                    <li>
                                        <a href="#" class="facebook"><i class="icofont-facebook"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" class="twitter"><i class="icofont-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" class="linkedin"><i class="icofont-linkedin"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" class="instagram"><i class="icofont-instagram"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" class="pinterest"><i class="icofont-pinterest"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div id="comments" class="comments">
                            <h4 class="title-border">02 Comment</h4>
                            <ul class="comment-list">
                                <li class="comment">
                                    <div class="com-thumb">
                                        <img alt="rajibraj91" src="assets/images/author/02.jpg">
                                    </div>
                                    <div class="com-content">
                                        <div class="com-title">
                                            <div class="com-title-meta">
                                                <h6>Linsa Faith</h6>
                                                <span> October 5, 2018 at 12:41 pm </span>
                                            </div>
                                            <span class="ratting">
                                                <i class="icofont-ui-rating"></i>
                                                <i class="icofont-ui-rating"></i>
                                                <i class="icofont-ui-rating"></i>
                                                <i class="icofont-ui-rating"></i>
                                                <i class="icofont-ui-rating"></i>
                                            </span>
                                        </div>
                                        <p>The inner sanctuary, I throw myself down among the tall grass bye the trckli
                                            stream and, as I lie close to the earth</p>
                                    </div>
                                    <ul class="comment-list">
                                        <li class="comment">
                                            <div class="com-thumb">
                                                <img alt="rajibraj91" src="assets/images/author/03.jpg">
                                            </div>
                                            <div class="com-content">
                                                <div class="com-title">
                                                    <div class="com-title-meta">
                                                        <h6>James Jusse</h6>
                                                        <span> October 5, 2018 at 12:41 pm </span>
                                                    </div>
                                                    <span class="ratting">
                                                        <i class="icofont-ui-rating"></i>
                                                        <i class="icofont-ui-rating"></i>
                                                        <i class="icofont-ui-rating"></i>
                                                        <i class="icofont-ui-rating"></i>
                                                        <i class="icofont-ui-rating"></i>
                                                    </span>
                                                </div>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these
                                                    sweet mornings spring which I enjoy with my whole heart</p>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                        <div id="respond" class="comment-respond mb-lg-0">
                            <h4 class="title-border">Leave a Comment</h4>
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
