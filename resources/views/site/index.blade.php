@extends('template.site')
@section('title', 'Início')

@section('footer')

@endsection

@section('conteudo')

    <!-- banner section start here -->
    <section class="banner-section style-1">
        <div class="container">
            <div class="section-wrapper">
                <div class="row align-items-center">
                    <div class="col-xxl-5 col-xl-6 col-lg-10">
                        <div class="banner-content">
                            <h6 class="subtitle text-uppercase fw-medium">EDUCAÇÃO ONLINE</h6>
                            <h2 class="title"><span class="d-lg-block">Aprenda as</span> Habilidades que você
                                precisa<span class="d-lg-block">Ter sucesso</span></h2>
                            <p class="desc">Cursos online. Ativando o seu código você terá acesso vitalício a todo
                                o conteúdo.</p>
                            <form action="/">
                                <div class="banner-icon">
                                    <i class="icofont-search"></i>
                                </div>
                                <input type="text" placeholder="Digite aqui o seu código de Ativação">
                                <button type="submit">Ativar Código</button>
                            </form>
                            <div class="banner-catagory d-flex flex-wrap">
                                <p>Cursos mais Acessados: </p>
                                <ul class="lab-ul d-flex flex-wrap">
                                    <li><a href="#">Figma</a></li>
                                    <li><a href="#">Adobe XD</a></li>
                                    <li><a href="#">illustration</a></li>
                                    <li><a href="#">Photoshop</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-7 col-xl-6">
                        <div class="banner-thumb">
                            <img src="{{ URL::asset('site/images/banner/01.png') }}" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="all-shapes"></div>
        <div class="cbs-content-list d-none">
            <ul class="lab-ul">
                <li class="ccl-shape shape-1"><a href="#">16M Estudantes Felizes</a></li>
                <li class="ccl-shape shape-2"><a href="#">Mais de 700K+ Cursos Totais</a></li>
                <li class="ccl-shape shape-3"><a href="#">89% de Estudantes bem-sucedidos</a></li>
                <li class="ccl-shape shape-4"><a href="#">Mais de 23k+ alunos</a></li>
                <li class="ccl-shape shape-5"><a href="#">3+ Idiomas</a></li>
            </ul>
        </div>
    </section>
    <!-- banner section ending here -->


    <!-- sponsor section start here -->
    <div class="sponsor-section section-bg">
        <div class="container">
            <div class="section-wrapper">
                <div class="sponsor-slider">
                    <div class="swiper-wrapper">

                        @foreach ($parceiro as $item)
                            <div class="swiper-slide">
                                <div class="sponsor-iten">
                                    <div class="sponsor-thumb">
                                        <img src="{{ URL::asset('storage/' . $item->logo) }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- sponsor section ending here -->


    <!-- category section start here -->
    <div class="category-section padding-tb">
        <div class="container">
            <div class="section-header text-center">
                <span class="subtitle">Categoria Popular</span>
                <h2 class="title">Categoria popular para aprender</h2>
            </div>
            <div class="section-wrapper">
                <div class="row g-2 justify-content-center row-cols-xl-6 row-cols-md-3 row-cols-sm-2 row-cols-1">
                    @foreach ($categoria as $item)
                        <div class="col">
                            <div class="category-item text-center">
                                <div class="category-inner">
                                    <div class="category-thumb">
                                        @if ($item->imagem != '')
                                            <img src="{{ URL::asset('storage/' . $item->imagem) }}" class="avatar-img">
                                        @else
                                            <img src="{{ URL::asset('storage/imagemCategoriaCurso/padrao.png') }}">
                                        @endif
                                    </div>
                                    <div class="category-content">
                                        <a href="{{ $item->id }}">
                                            <h6>{{ $item->nome }}</h6>
                                        </a>
                                        <span>24 Cursos</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-5">
                    <a href="course.html" class="lab-btn"><span>Navegar em todas as categorias</span></a>
                </div>
            </div>
        </div>
    </div>
    <!-- category section start here -->

    @if (count($curso) > 0)
        <!-- course section start here -->
        <div class="course-section padding-tb section-bg">
            <div class="container">
                <div class="section-header text-center">
                    <span class="subtitle">CURSOS EM DESTAQUE</span>
                    <h2 class="title">Escolha um curso para começar</h2>
                </div>
                <div class="section-wrapper">
                    <div class="row g-4 justify-content-center row-cols-xl-3 row-cols-md-2 row-cols-1">
                        @foreach ($curso as $item)
                            <div class="col">
                                <div class="course-item">
                                    <div class="course-inner">
                                        <div class="course-thumb">
                                            <img src="{{ URL::asset('storage/' . $item->imagem) }}" alt="course">
                                        </div>
                                        <div class="course-content">
                                            <div class="course-category">
                                                <div class="course-cate">
                                                    <a href="{{ $item->categoria_id }}">{{ $item->categoria }}</a>
                                                </div>
                                                <div class="course-reiew">
                                                    <span class="ratting">
                                                        <i class="icofont-ui-rating"></i>
                                                        <i class="icofont-ui-rating"></i>
                                                        <i class="icofont-ui-rating"></i>
                                                        <i class="icofont-ui-rating"></i>
                                                        <i class="icofont-ui-rating"></i>
                                                    </span>

                                                </div>
                                            </div>
                                            <a href="course-single.html">
                                                <h5>{{ $item->nome }}</h5>
                                            </a>
                                            <div class="course-details">
                                                <div class="couse-count"><i class="icofont-video-alt"></i> 18x Lesson
                                                </div>
                                                <div class="couse-topic"><span class="ratting-count">03 reviews</span>
                                                </div>
                                            </div>
                                            <div class="course-footer">
                                                <div class="course-author">
                                                    @if ($item->avatar != '')
                                                        <img src="{{ URL::asset('storage/' . $item->avatar) }}"
                                                            style="width: 50px" class="avatar-img">
                                                    @else
                                                        <img src="{{ URL::asset('storage/avatarProfessor/padrao.png') }}"
                                                            style="width: 50px">
                                                    @endif
                                                    <a href="team-single.html"
                                                        class="ca-name">{{ $item->professor }}</a>
                                                </div>
                                                <div class="course-btn">
                                                    <a href="course-single.html" class="lab-btn-text">Conhecer <i
                                                            class="icofont-external-link"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- course section ending here -->
    @endif

    <!-- abouts section start here -->
    <div class="about-section">
        <div class="container">
            <div class="row justify-content-center row-cols-xl-2 row-cols-1 align-items-end flex-row-reverse">
                <div class="col">
                    <div class="about-right padding-tb">
                        <div class="section-header">
                            <span class="subtitle">SOBRE O NOSSO EDUK</span>
                            <h2 class="title">Bons serviços de qualificação e melhores habilidades</h2>
                            <p>Distintamente fornecer acesso a usuários mutáveis ​​enquanto processos transparentes
                                incentivam funcionalidades eficientes ao invés de arquitetura extensível comunicar serviços
                                alavancados e multiplataforma.</p>
                        </div>
                        <div class="section-wrapper">
                            <ul class="lab-ul">
                                <li>
                                    <div class="sr-left">
                                        <img src="{{ URL::asset('site/images/about/icon/01.jpg') }}" alt="about icon">
                                    </div>
                                    <div class="sr-right">
                                        <h5>Instrutores qualificados</h5>
                                        <p>Distintamente fornecer usuários mutfuncto de acesso enquanto comunica serviços
                                            alavancados</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="sr-left">
                                        <img src="{{ URL::asset('site/images/about/icon/02.jpg') }}" alt="about icon">
                                    </div>
                                    <div class="sr-right">
                                        <h5>Obter certificado</h5>
                                        <p>Distintamente fornecer usuários mutfuncto de acesso enquanto comunica serviços
                                            alavancados</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="sr-left">
                                        <img src="{{ URL::asset('site/images/about/icon/03.jpg') }}" alt="about icon">
                                    </div>
                                    <div class="sr-right">
                                        <h5>Aulas Online</h5>
                                        <p>Distintamente fornecer usuários mutfuncto de acesso enquanto comunica serviços
                                            alavancados</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="about-left">
                        <div class="about-thumb">
                            <img src="{{ URL::asset('site/images/about/01.png') }}" alt="about">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about section ending here -->


    <!-- Instructors Section Start Here -->
    <div class="instructor-section padding-tb section-bg">
        <div class="container">
            <div class="section-header text-center">
                <span class="subtitle">INSTRUTORES ESPECIALISTAS DE CADA CONTEÚDO</span>
                <h2 class="title">Aulas ministradas por criadores reais
                </h2>
            </div>
            <div class="section-wrapper">
                <div class="row g-4 justify-content-center row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4">
                    <div class="col">
                        <div class="instructor-item">
                            <div class="instructor-inner">
                                <div class="instructor-thumb">
                                    <img src="{{ URL::asset('site/images/instructor/01.jpg') }}" alt="instructor">
                                </div>
                                <div class="instructor-content">
                                    <a href="team-single.html">
                                        <h4>Emilee Logan</h4>
                                    </a>
                                    <p>Master of Education Degree</p>
                                    <span class="ratting">
                                        <i class="icofont-ui-rating"></i>
                                        <i class="icofont-ui-rating"></i>
                                        <i class="icofont-ui-rating"></i>
                                        <i class="icofont-ui-rating"></i>
                                        <i class="icofont-ui-rating"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="instructor-footer">
                                <ul class="lab-ul d-flex flex-wrap justify-content-between align-items-center">
                                    <li><i class="icofont-book-alt"></i> 08 courses</li>
                                    <li><i class="icofont-users-alt-3"></i> 30 students</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="instructor-item">
                            <div class="instructor-inner">
                                <div class="instructor-thumb">
                                    <img src="{{ URL::asset('site/images/instructor/02.jpg') }}" alt="instructor">
                                </div>
                                <div class="instructor-content">
                                    <a href="team-single.html">
                                        <h4>Donald Logan</h4>
                                    </a>
                                    <p>Master of Education Degree</p>
                                    <span class="ratting">
                                        <i class="icofont-ui-rating"></i>
                                        <i class="icofont-ui-rating"></i>
                                        <i class="icofont-ui-rating"></i>
                                        <i class="icofont-ui-rating"></i>
                                        <i class="icofont-ui-rating"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="instructor-footer">
                                <ul class="lab-ul d-flex flex-wrap justify-content-between align-items-center">
                                    <li><i class="icofont-book-alt"></i> 08 courses</li>
                                    <li><i class="icofont-users-alt-3"></i> 30 students</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="instructor-item">
                            <div class="instructor-inner">
                                <div class="instructor-thumb">
                                    <img src="{{ URL::asset('site/images/instructor/03.jpg') }}" alt="instructor">
                                </div>
                                <div class="instructor-content">
                                    <a href="team-single.html">
                                        <h4>Oliver Porter</h4>
                                    </a>
                                    <p>Master of Education Degree</p>
                                    <span class="ratting">
                                        <i class="icofont-ui-rating"></i>
                                        <i class="icofont-ui-rating"></i>
                                        <i class="icofont-ui-rating"></i>
                                        <i class="icofont-ui-rating"></i>
                                        <i class="icofont-ui-rating"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="instructor-footer">
                                <ul class="lab-ul d-flex flex-wrap justify-content-between align-items-center">
                                    <li><i class="icofont-book-alt"></i> 08 courses</li>
                                    <li><i class="icofont-users-alt-3"></i> 30 students</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="instructor-item">
                            <div class="instructor-inner">
                                <div class="instructor-thumb">
                                    <img src="{{ URL::asset('site/images/instructor/04.jpg') }}" alt="instructor">
                                </div>
                                <div class="instructor-content">
                                    <a href="team-single.html">
                                        <h4>Nahla Jones</h4>
                                    </a>
                                    <p>Master of Education Degree</p>
                                    <span class="ratting">
                                        <i class="icofont-ui-rating"></i>
                                        <i class="icofont-ui-rating"></i>
                                        <i class="icofont-ui-rating"></i>
                                        <i class="icofont-ui-rating"></i>
                                        <i class="icofont-ui-rating"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="instructor-footer">
                                <ul class="lab-ul d-flex flex-wrap justify-content-between align-items-center">
                                    <li><i class="icofont-book-alt"></i> 08 courses</li>
                                    <li><i class="icofont-users-alt-3"></i> 30 students</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center footer-btn">
                    <p>Want to help people learn, grow and achieve more in life?<a href="team.html">Become an instructor</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Instructors Section Ending Here -->

    <!-- Achievement section start here -->
    <div class="achievement-section padding-tb">
        <div class="container">
            <div class="section-header text-center">
                <span class="subtitle">COMECE A TER SUCESSO</span>
                <h2 class="title">Alcance seus objetivos com Edukon</h2>
            </div>
            <div class="section-wrapper">
                <div class="counter-part mb-4">
                    <div class="row g-4 row-cols-lg-4 row-cols-sm-2 row-cols-1 justify-content-center">
                        <div class="col">
                            <div class="count-item">
                                <div class="count-inner">
                                    <div class="count-content">
                                        <h2><span class="count" data-to="30"
                                                data-speed="1500"></span><span>+</span></h2>
                                        <p>Years of Language Education Experience</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="count-item">
                                <div class="count-inner">
                                    <div class="count-content">
                                        <h2><span class="count" data-to="3080"
                                                data-speed="1500"></span><span>+</span></h2>
                                        <p>Learners Enrolled in Edukon Courses</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="count-item">
                                <div class="count-inner">
                                    <div class="count-content">
                                        <h2><span class="count" data-to="330"
                                                data-speed="1500"></span><span>+</span></h2>
                                        <p>Qualified Teachers And Language Experts</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="count-item">
                                <div class="count-inner">
                                    <div class="count-content">
                                        <h2><span class="count" data-to="2300"
                                                data-speed="1500"></span><span>+</span></h2>
                                        <p>Innovative Foreign Language Courses</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="achieve-part">
                    <div class="row g-4 row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <div class="achieve-item">
                                <div class="achieve-inner">
                                    <div class="achieve-thumb">
                                        <img src="{{ URL::asset('site/images/achive/01.png') }}" alt="achieve thumb">
                                    </div>
                                    <div class="achieve-content">
                                        <h4>Start Teaching Today</h4>
                                        <p>Seamlessly engage technically sound coaborative reintermed goal oriented content
                                            rather than ethica</p>
                                        <a href="#" class="lab-btn"><span>Become A Instructor</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="achieve-item">
                                <div class="achieve-inner">
                                    <div class="achieve-thumb">
                                        <img src="{{ URL::asset('site/images/achive/02.png') }}" alt="achieve thumb">
                                    </div>
                                    <div class="achieve-content">
                                        <h4>If You Join Our Course</h4>
                                        <p>Seamlessly engage technically sound coaborative reintermed goal oriented content
                                            rather than ethica</p>
                                        <a href="#" class="lab-btn"><span>Register For Free</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Achievement section ending here -->

@endsection
