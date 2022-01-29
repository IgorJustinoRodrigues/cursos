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
                    <div class="col-xl-6 pb-5 pb-xl-0 d-flex flex-wrap justify-content-lg-start justify-content-between">
                        <h4 class="subtitle">Personal Language Skill</h4>
                        <div class="text-center skill-item">
                            <div class="skill-thumb">
                                <div class="circles text-center">
                                    <div class="circle first" data-percent="80">
                                        <strong>80<i>%</i></strong>
                                    </div>
                                </div>
                            </div>
                            <p>English</p>
                        </div>
                        <div class="text-center skill-item">
                            <div class="skill-thumb">
                                <div class="circles text-center">
                                    <div class="circle second" data-percent="70">
                                        <strong>70<i>%</i></strong>
                                    </div>
                                </div>
                            </div>
                            <p>Hindi</p>
                        </div>
                        <div class="text-center skill-item">
                            <div class="skill-thumb">
                                <div class="circles text-center">
                                    <div class="circle third" data-percent="60">
                                        <strong>60<i>%</i></strong>
                                    </div>
                                </div>
                            </div>
                            <p>Bangla</p>
                        </div>
                    </div>
                    <div class="col-xl-6 d-flex flex-wrap justify-content-lg-start justify-content-between">
                        <h4 class="subtitle">Recognitions Award</h4>
                        <div class="skill-item text-center">
                            <div class="skill-thumb">
                                <img src="{{ URL::asset('site/images/instructor/single/icon/01.png') }}"
                                    alt="instructor">
                            </div>
                            <p>Award 2018</p>
                        </div>
                        <div class="skill-item text-center">
                            <div class="skill-thumb">
                                <img src="{{ URL::asset('site/images/instructor/single/icon/02.png') }}"
                                    alt="instructor">
                            </div>
                            <p>Award 2019</p>
                        </div>
                        <div class="skill-item text-center">
                            <div class="skill-thumb">
                                <img src="{{ URL::asset('site/images/instructor/single/icon/03.png') }}" alt="instructor">
                            </div>
                            <p>Award 2020</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- instructor Single Section Ends Here -->
@endsection
