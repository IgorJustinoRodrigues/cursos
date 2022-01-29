@extends('template.site')
@section('title', 'Cursos')

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
    <!-- -->
    <!-- Page Header section start here -->
    <div class="pageheader-section" style="padding: 55px 0 92px !important">

    </div>
    <!-- Page Header section ending here -->

    <!-- group select section start here -->
    <div class="group-select-section">
        <div class="container">
            <div class="section-wrapper">
                <div class="row align-items-center g-4">
                    <div class="col-md-1">
                        <div class="group-select-left">
                            <i class="icofont-abacus-alt"></i>
                            <span>Filtros</span>
                        </div>
                    </div>
                    <form class="col-md-11" action="{{ route('site.cursos') }}" method="get" id="form-busca">
                        <input type="hidden" name="page" value="1">
                        <div class="group-select-right">
                            <div class="row g-2 row-cols-lg-4 row-cols-sm-2 row-cols-1">
                                <div class="col">
                                    <div class="select-item">
                                        <input type="text" name="busca" value="{{ $busca }}"
                                            onchange="$('#form-busca').submit();">
                                        <div class="select-icon" onclick="$('#form-busca').submit();">
                                            <i class="icofont-search-2"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="select-item">
                                        <select name="categoria" onchange="$('#form-busca').submit();">
                                            <option value="">Selecione a Categoria</option>
                                            @foreach ($categorias as $linha)
                                                <option value="{{ $linha->id }}" @if ($categoria == $linha->id) selected @endif>
                                                    {{ $linha->nome }}</option>
                                            @endforeach
                                        </select>
                                        <div class="select-icon">
                                            <i class="icofont-rounded-down"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="select-item">
                                        <select name="ordem" onchange="$('#form-busca').submit();">
                                            <option value="">Ordenar por</option>
                                            <option value="1" @if ($ordem == 1) selected @endif>Destaques</option>
                                            <option value="2" @if ($ordem == 2) selected @endif>Nível: iniciante a avançado</option>
                                            <option value="3" @if ($ordem == 3) selected @endif>Nível: avançado a iniciante</option>
                                            <option value="4" @if ($ordem == 4) selected @endif>Melhores avaliações</option>
                                            <option value="5" @if ($ordem == 5) selected @endif>Novidades</option>
                                        </select>
                                        <div class="select-icon">
                                            <i class="icofont-rounded-down"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
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
                                <span>
                                    Exibindo {{ $curso->firstItem() }} - {{ $curso->lastItem() }} DE
                                    {{ $curso->total() }} CURSOS
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 justify-content-center row-cols-xl-3 row-cols-md-2 row-cols-1">
                        @foreach ($curso as $item)
                            <div class="col">
                                <div class="course-item">
                                    <div class="course-inner">
                                        <div class="course-thumb">
                                            <a
                                                href="{{ route('site.lerCurso', [$item->id, Str::slug($item->nome) . '.html']) }}">
                                                @if ($item->imagem != '')
                                                    <img src="{{ URL::asset('storage/' . $item->imagem) }}" alt="">
                                                @else
                                                    <img src="{{ URL::asset('storage/imagemCurso/padrao.png') }}" alt="">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="course-content">
                                            <div class="course-category">
                                                <div class="course-cate">
                                                    <a
                                                        href="{{ route('site.cursos', [$item->categoria_id, $item->categoria]) }}">{{ $item->categoria }}</a>
                                                </div>
                                                <div class="course-reiew">
                                                    <span class="ratting">
                                                        @for ($i = 1; $i < 6; $i++)
                                                            @if ($i <= $item->estrelas)
                                                                <i class="icofont-ui-rating dourado"></i>
                                                            @else
                                                                <i class="icofont-ui-rating prata"></i>
                                                            @endif
                                                        @endfor
                                                    </span>
                                                </div>
                                            </div>
                                            <a
                                                href="{{ route('site.lerCurso', [$item->id, Str::slug($item->nome) . '.html']) }}">
                                                <h5>{{ $item->nome }}</h5>
                                            </a>
                                            <div class="course-details">
                                                <div class="couse-count"><i class="icofont-video-alt"></i>
                                                    {{ $item->total_aula }}
                                                    @if ($item->total_aula == 1) Aula @else Aulas @endif
                                                </div>
                                                <div class="couse-topic"><i
                                                        class="icofont-signal"></i>{{ app(App\Http\Controllers\CursoController::class)->tipo($item->tipo, true) }}
                                                </div>
                                            </div>
                                            <div class="course-footer">
                                                <div class="course-author">
                                                    @if ($item->avatar_professor != '')
                                                        <a href="{{ route('site.Professor') }}">
                                                            <img src="{{ URL::asset('storage/' . $item->avatar_professor) }}"
                                                                class="rounded-circle" style="width: 50px">
                                                        </a>
                                                    @else
                                                        <a href="{{ route('site.Professor') }}">
                                                            <img src="{{ URL::asset('storage/avatarProfessor/padrao.png') }}"
                                                                class="rounded-circle" style="width: 50px"></a>
                                                    @endif
                                                    <a href="{{ route('site.Professor') }}">
                                                        <span class="ca-name">{{ $item->professor }}</span>
                                                    </a>
                                                </div>
                                                <div class="course-btn">
                                                    <a href="{{ route('site.lerCurso', [$item->id, Str::slug($item->nome) . '.html']) }}"
                                                        class="lab-btn-text">Ver Curso <i
                                                            class="icofont-external-link"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $curso->links('site.paginacao.cursos', ['busca' => $busca, 'categoria' => $categoria, 'ordem' => $ordem]) }}
                </div>
            </div>
        </div>
        <!-- course section ending here -->
    @else


        <div class="container mt-5 mb-5">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="post-item style-2">
                        <div class="post-inner">
                            <div class="post-content">
                                <h2 class="not-ruselt">Não encontramos nenhum curso com essas características de busca!
                                </h2>
                                <h2 class="opps">Oops!</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
