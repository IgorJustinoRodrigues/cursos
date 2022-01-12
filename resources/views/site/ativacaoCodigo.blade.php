@extends('template.site')
@section('title', 'Ativação do Código')

@section('header')

@endsection

@section('footer')

@endsection

@section('conteudo')
    <!-- Page Header section start here -->
    <div class="pageheader-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="pageheader-content text-center">
                        <h2>Primeira Ativação do seu Código ?</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="#">Início</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Ativar Código</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header section ending here -->

    <!-- student feedbak section start here -->
    <div class="student-feedbak-section padding-tb shape-img">
        <div class="container">
            <div class="section-header text-center">
                <span class="subtitle">Saiba como ativar o seu código de ativação</span>
                <h2 class="title">E começe a estudar agora mesmo.</h2>
            </div>
            <div class="section-wrapper">
                <div class="row justify-content-center row-cols-lg-2 row-cols-1">
                    <div class="col">
                        <div class="sf-left">
                            <div class="sfl-thumb">
                                <img src="{{ URL::asset('site/images/feedback/01.jpg') }}" alt="student feedback">
                                <a href="https://www.youtube-nocookie.com/embed/jP649ZHA8Tg" class="video-button"
                                    data-rel="lightcase"><i class="icofont-ui-play"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="stu-feed-item">
                            <div class="stu-feed-inner">
                                <div class="stu-feed-top">
                                    <div class="sft-left">
                                        <div class="sftl-thumb">
                                            <img src="{{ URL::asset('site/images/feedback/student/01.jpg') }}"
                                                alt="student feedback">
                                        </div>
                                        <div class="sftl-content">
                                            <a href="#">
                                                <h6>Oliver Beddows</h6>
                                            </a>
                                            <span>UX designer</span>
                                        </div>
                                    </div>
                                    <div class="sft-right">
                                        <span class="ratting">
                                            <i class="icofont-ui-rating"></i>
                                            <i class="icofont-ui-rating"></i>
                                            <i class="icofont-ui-rating"></i>
                                            <i class="icofont-ui-rating"></i>
                                            <i class="icofont-ui-rating"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="stu-feed-bottom">
                                    <p>Rapidiously buildcollaboration anden deas sharing viaing and with bleedng edgeing
                                        nterfaces fnergstcally plagiarize teams anbuling paradgms whereas goingi forward
                                        process and monetze</p>
                                </div>
                            </div>
                        </div>
                        <div class="stu-feed-item">
                            <div class="stu-feed-inner">
                                <div class="stu-feed-top">
                                    <div class="sft-left">
                                        <div class="sftl-thumb">
                                            <img src="{{ URL::asset('site/images/feedback/student/02.jpg') }}"
                                                alt="student feedback">
                                        </div>
                                        <div class="sftl-content">
                                            <a href="#">
                                                <h6>Madley Pondor</h6>
                                            </a>
                                            <span>UX designer</span>
                                        </div>
                                    </div>
                                    <div class="sft-right">
                                        <span class="ratting">
                                            <i class="icofont-ui-rating"></i>
                                            <i class="icofont-ui-rating"></i>
                                            <i class="icofont-ui-rating"></i>
                                            <i class="icofont-ui-rating"></i>
                                            <i class="icofont-ui-rating"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="stu-feed-bottom">
                                    <p>Rapidiously buildcollaboration anden deas sharing viaing and with bleedng edgeing
                                        nterfaces fnergstcally plagiarize teams anbuling paradgms whereas goingi forward
                                        process and monetze</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- student feedbak section ending here -->
@endsection
