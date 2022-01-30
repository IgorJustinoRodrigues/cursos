@extends('template.site')
@section('title', 'Professor')

@section('header')

@endsection

@section('footer')

@endsection

@section('conteudo')
    <!--Tela de Professor-->

    <!-- Page Header section start here -->
    <div class="pageheader-section" style="padding: 55px 0 92px !important">

    </div>
    <!-- Page Header section ending here -->

    <!-- instructor Single Section Starts Here -->
    <section class="instructor-single-section padding-tb section-bg">
        <div class="container">
            <div class="instructor-wrapper">
                <div class="instructor-single-top">
                    <div class="instructor-single-item d-flex flex-wrap justify-content-between">
                        <div class="instructor-single-thumb">
                            @if ($professor->avatar != '')
                                <img src="{{ URL::asset('storage/' . $professor->avatar) }}" class="avatar-img">
                            @else
                                <img src="{{ URL::asset('storage/avatarProfessor/padrao.png') }}">
                            @endif
                        </div>
                        <div class="instructor-single-content">
                            <h4 class="title">{{ $professor->nome }}</h4>
                            <p class="ins-dege"></p>
                            <span class="ratting">
                                <i class="icofont-ui-rating"></i>
                                <i class="icofont-ui-rating"></i>
                                <i class="icofont-ui-rating"></i>
                                <i class="icofont-ui-rating"></i>
                                <i class="icofont-ui-rating"></i>
                            </span>
                            <h6 class="subtitle">Breve Currículo do Professor</h6>
                            <p class="ins-desc">{{ $professor->curriculo }}</p>
                            <ul class="lab-ul">
                                <li class="d-flex flex-wrap justify-content-start">
                                    <span class="list-name">Email</span>
                                    <span class="list-attr">{{ $professor->email }}</span>
                                </li>
                                <li class="d-flex flex-wrap justify-content-start">
                                    <span class="list-name">Facebook</span>
                                    <span class="list-attr">{{ $professor->facebook }}</span>
                                </li>
                                <li class="d-flex flex-wrap justify-content-start">
                                    <span class="list-name">Instagram</span>
                                    <span class="list-attr">{{ $professor->instagram }}</span>
                                </li>
                                <li class="d-flex flex-wrap justify-content-start">
                                    <span class="list-name">website</span>
                                    <span class="list-attr">{{ $professor->site }}</span>
                                </li>
                                <li class="d-flex flex-wrap justify-content-start">
                                    <span class="list-name">Siga-nos</span>
                                    <ul class="lab-ul list-attr d-flex flex-wrap justify-content-start">
                                        <li>
                                            <a class="twitter" href="{{ $professor->facebook }}"><i
                                                    class="icofont-facebook"></i></a>
                                        </li>
                                        <li>
                                            <a class="instagram" href="{{ $professor->instagram }}"><i
                                                    class="icofont-instagram"></i></a>
                                        </li>
                                        <li>
                                            <a class="vimeo" href="{{ $professor->linkedin }}"><i
                                                    class="icofont-linkedin"></i></a>
                                        </li>
                                        <li>
                                            <a class="beahnce" href="{{ $professor->site }}"><i
                                                    class="icofont-globe"></i></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="instructor-single-bottom d-flex flex-wrap mt-4">
                    <!-- Course Section Start Here -->



                    <!-- Course Section Start Here -->
                    <div
                        class="course-section style-2 col-xl-12 pb-5 pb-xl-0 d-flex flex-wrap justify-content-lg-start justify-content-between">
                        <div class="container">
                            <span class="title"><h5> Cursos do Professor(a): {{ $professor->nome }}</h5></span>
                            <div class="section-header">

                                <div class="course-navigations">
                                    <div class="course-navi course-navi-next"><i class="icofont-double-left"></i>
                                    </div>
                                    <div class="course-navi course-navi-prev"><i class="icofont-double-right"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="section-wrapper">
                                <div class="course-slider p-2">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="course-item style-3">
                                                <div class="course-inner text-center">
                                                    <div class="course-thumb">
                                                        <img src="{{ URL::asset('site/images/course/13.jpg') }}"
                                                            alt="course">
                                                        <ul class="course-info lab-ul">
                                                            <li>
                                                                <span class="ratting">
                                                                    <i class="icofont-ui-rate-blank"></i>
                                                                    <i class="icofont-ui-rate-blank"></i>
                                                                    <i class="icofont-ui-rate-blank"></i>
                                                                    <i class="icofont-ui-rate-blank"></i>
                                                                    <i class="icofont-ui-rate-blank"></i>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="course-content">
                                                        <a href="course-single.html">
                                                            <h6>Learn Basic Web Design with HTML & CSS</h6>
                                                        </a>
                                                        <a href="course-single.html" class="lab-btn"><span>Read
                                                                More</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="course-item style-3">
                                                <div class="course-inner text-center">
                                                    <div class="course-thumb">
                                                        <img src="{{ URL::asset('site/images/course/14.jpg') }}"
                                                            alt="course">
                                                        <ul class="course-info lab-ul">
                                                            <li>
                                                                <span class="ratting">
                                                                    <i class="icofont-ui-rate-blank"></i>
                                                                    <i class="icofont-ui-rate-blank"></i>
                                                                    <i class="icofont-ui-rate-blank"></i>
                                                                    <i class="icofont-ui-rate-blank"></i>
                                                                    <i class="icofont-ui-rate-blank"></i>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="course-content">
                                                        <a href="course-single.html">
                                                            <h6>Learn Basic Web Design with HTML & CSS</h6>
                                                        </a>
                                                        <a href="course-single.html" class="lab-btn"><span>Read
                                                                More</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="course-item style-3">
                                                <div class="course-inner text-center">
                                                    <div class="course-thumb">
                                                        <img src="{{ URL::asset('site/images/course/15.jpg') }}"
                                                            alt="course">
                                                        <ul class="course-info lab-ul">
                                                            <li>
                                                                <span class="ratting">
                                                                    <i class="icofont-ui-rate-blank"></i>
                                                                    <i class="icofont-ui-rate-blank"></i>
                                                                    <i class="icofont-ui-rate-blank"></i>
                                                                    <i class="icofont-ui-rate-blank"></i>
                                                                    <i class="icofont-ui-rate-blank"></i>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="course-content">
                                                        <a href="course-single.html">
                                                            <h6>Learn Basic Web Design with HTML & CSS</h6>
                                                        </a>
                                                        <a href="course-single.html" class="lab-btn"><span>Read
                                                                More</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Course Section Ending Here -->

                </div>
            </div>
        </div>

    </section>
    <!-- instructor Single Section Ends Here -->

@endsection
