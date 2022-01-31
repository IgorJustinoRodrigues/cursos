@extends('template.site')
@section('title', 'Suporte')

@section('header')
    <style>
        .titulo {
            color: #ffffff;
        }

    </style>
@endsection

@section('footer')

@endsection

@section('conteudo')
    <!-- Page Header section start here -->
    <div class="pageheader-section" style="padding: 55px 0 92px !important">
    </div>
    <!-- Page Header section ending here -->
    <!-- features section start here -->
    <div class="feature-section padding-tb">
        <div class="container">
            <div class="section-header text-center">
                <span class="subtitle"></span>
                <h2 class="title"></h2>
            </div>
            <div class="section-wrapper">
                <div class="row g-4 row-cols-lg-3 row-cols-sm-2 row-cols-1 justify-content-center">
                    <div class="col">
                        <div class="feature-item">
                            <div class="feature-inner">
                                <div class="feature-thumb">
                                    <img src="{{ URL::asset('site/images/feature/01.png') }}" alt="feature">
                                </div>
                                <div class="feature-content">
                                    <a href="#">
                                        <h5>Perguntas Frequentes </h5>
                                    </a>
                                    <a href="#" class="lab-btn-text">Conhecer <span></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="feature-item">
                            <div class="feature-inner">
                                <div class="feature-thumb">
                                    <img src="{{ URL::asset('site/images/feature/01.png') }}" alt="feature">
                                </div>
                                <div class="feature-content">
                                    <a href="#">
                                        <h5>Certificados</h5>
                                    </a>
                                    <a href="#" class="lab-btn-text">Conhecer <span></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="feature-item">
                            <div class="feature-inner">
                                <div class="feature-thumb">
                                    <img src="{{ URL::asset('site/images/feature/01.png') }}" alt="feature">
                                </div>
                                <div class="feature-content">
                                    <a href="#">
                                        <h5>Suporte Aluno</h5>
                                    </a>
                                    <a href="#" class="lab-btn-text">Conhecer <span></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="feature-item">
                            <div class="feature-inner">
                                <div class="feature-thumb">
                                    <img src="{{ URL::asset('site/images/feature/01.png') }}" alt="feature">
                                </div>
                                <div class="feature-content">
                                    <a href="#">
                                        <h5>Suporte Vendedor</h5>
                                    </a>
                                    <a href="#" class="lab-btn-text">Conhecer <span></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="feature-item">
                            <div class="feature-inner">
                                <div class="feature-thumb">
                                    <img src="{{ URL::asset('site/images/feature/01.png') }}" alt="feature">
                                </div>
                                <div class="feature-content">
                                    <a href="#">
                                        <h5>Suporte Unidade</h5>
                                    </a>
                                    <a href="#" class="lab-btn-text">Conhecer <span></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="feature-item">
                            <div class="feature-inner">
                                <div class="feature-thumb">
                                    <img src="{{ URL::asset('site/images/feature/01.png') }}" alt="feature">
                                </div>
                                <div class="feature-content">
                                    <a href="#">
                                        <h5>Suporte Parceiro</h5>
                                    </a>
                                    <a href="#" class="lab-btn-text">Conhecer <span></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- features section ending here -->
   
@endsection
