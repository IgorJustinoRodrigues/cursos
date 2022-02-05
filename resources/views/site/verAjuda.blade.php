@extends('template.site')
@section('title', 'Ajuda')

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
    <div class="blog-section blog-single padding-tb section-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-12">
                    <article>
                        <div class="section-wrapper">
                            <div class="row row-cols-1 justify-content-center g-4">
                                <div class="col">
                                    <div class="post-item style-2">
                                        <div class="post-inner">
                                            <div class="post-content">
                                                <h2>{{ $ajuda->nome }}</h2>

                                                {!! $ajuda->texto !!}

                                                <div class="tags-section">
                                                    <ul class="tags lab-ul">
                                                        <li><a href="">{{ $ajuda->categoria }}</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-lg-4 col-12">
                    <aside>

                        <div class="widget widget-category">
                            <div class="widget-header">
                                <h5 class="title">{{ $ajuda->categoria }}</h5>
                            </div>
                            <ul class="widget-wrapper">
                                @foreach ($telasAtual as $linha)
                                    <li>
                                        <a href="{{ route('site.verAjuda', [$linha->id, Str::slug($linha->nome, '-') . '.html']) }}"
                                            class="d-flex flex-wrap @if ($linha->id == $ajuda->id) active @endif justify-content-between"><span><i
                                                    class="icofont-double-right"></i>{{ $linha->nome }}</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>


                        <div class="widget widget-archive">
                            <div class="widget-header">
                                <h5 class="title">Todos os Assuntos</h5>
                            </div>
                            <ul class="widget-wrapper">
                                @foreach ($categoriasAjuda as $categoriaLinha)
                                    <li>
                                        <a href="{{ route('site.verAjuda', [ $categoriaLinha->telas[0]->id, Str::slug( $categoriaLinha->telas[0]->nome, '-') . '.html']  ) }}"
                                        class="d-flex flex-wrap justify-content-between"><span><i
                                                class="icofont-double-right"></i>{{ $categoriaLinha->nome }}</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>


                    </aside>
                </div>
            </div>
        </div>
    </div>

@endsection
