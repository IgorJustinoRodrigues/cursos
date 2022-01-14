@extends('template.site')
@section('title', 'Cursos')

@section('header')

@endsection

@section('footer')

@endsection

@section('conteudo')
    <!-- -->
    <!-- Page Header section start here -->
    <div class="pageheader-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="pageheader-content text-center">
                        <h2>Cursos</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="#">Início</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Cursos</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header section ending here -->

    <!-- group select section start here -->
    <div class="group-select-section" style="padding-left: 300px !important; ">
        <div class="container">
            <div class="section-wrapper">
                <div class="row align-items-center g-4">
                    <div class="col-md-1">
                        <div class="group-select-left">
                            <i class="icofont-abacus-alt"></i>
                            <span>Filtros</span>
                        </div>
                    </div>
                    <div class="col-md-11">
                        <div class="group-select-right">
                            <div class="row g-2 row-cols-lg-4 row-cols-sm-2 row-cols-1">
                                <div class="col">
                                    <div class="select-item">
                                        <input type="text">
                                        <div class="select-icon">
                                            <i class="icofont-search-2"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="select-item">
                                        <select>
                                            <option value="">Selecione a Categoria</option>
                                            <option value="uncategorized">Uncategorized</option>
                                            <option value="academy">Academy</option>
                                            <option value="agency">Agency</option>
                                            <option value="app">App</option>
                                            <option value="bar">Bar</option>
                                        </select>
                                        <div class="select-icon">
                                            <i class="icofont-rounded-down"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="select-item">
                                        <select>
                                            <option value="">Ordenar por</option>
                                            <option value="29">29</option>
                                            <option value="39">39</option>
                                            <option value="69">69</option>
                                            <option value="99">99</option>
                                            <option value="199">199</option>
                                        </select>
                                        <div class="select-icon">
                                            <i class="icofont-rounded-down"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- group select section ending here -->


    @if (count($curso) > 0)
        <div class="course-section padding-tb section-bg">
            <div class="container">
                <div class="section-wrapper">
                    <div class="course-showing-part">
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <div class="course-showing-part-left">
                                <p>Mostrando 1-6 de 10 resultados</p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 justify-content-center row-cols-xl-3 row-cols-md-2 row-cols-1">
                        @foreach ($curso as $item)
                            <div class="col">
                                <div class="course-item">
                                    <div class="course-inner">
                                        <div class="course-thumb">
                                            <img src="{{ URL::asset('storage/' . $item->imagem) }}" alt="course">
                                        </div>
                                        <div class="course-content">
                                            <div class="course-price">$30</div>
                                            <div class="course-category">
                                                <div class="course-cate">
                                                    <a href="{{ route('site.lerCurso', ['10', 'lerCurso.html']) }}">{{$item->categoria}}</a>
                                                </div>
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
                                            <a href="{{ route('site.lerCurso', ['10', 'lerCurso.html']) }}">
                                                <h5>{{ $item->nome }}</h5>
                                            </a>
                                            <div class="course-details">
                                                <div class="couse-count"><i class="icofont-video-alt"></i> 18x Lesson
                                                </div>
                                                <div class="couse-topic"><i class="icofont-signal"></i> Online Class
                                                </div>
                                            </div>
                                            <div class="course-footer">
                                                <div class="course-author">
                                                    <img src="{{ URL::asset('site/images/course/author/01.jpg') }}"
                                                        alt="course author">
                                                    <a href="team-single.html" class="ca-name">{{$item->professor}}</a>
                                                </div>
                                                <div class="course-btn">
                                                    <a href="{{ route('site.lerCurso', ['10', 'lerCurso.html']) }}"
                                                        class="lab-btn-text">Read More <i
                                                            class="icofont-external-link"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <ul class="default-pagination lab-ul">
                        <li>
                            <a href="#"><i class="icofont-rounded-left"></i></a>
                        </li>
                        <li>
                            <a href="#">01</a>
                        </li>
                        <li>
                            <a href="#" class="active">02</a>
                        </li>
                        <li>
                            <a href="#">03</a>
                        </li>
                        <li>
                            <a href="#"><i class="icofont-rounded-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- course section ending here -->
    @endif
@endsection
