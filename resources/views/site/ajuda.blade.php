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
    <!-- features section start here -->
    <div class="feature-section padding-tb">
        <div class="container">
            <div class="section-header text-center">
                <span class="subtitle"></span>
                <h2 class="title"></h2>
            </div>
            <div class="section-wrapper">
                <div class="row g-4 row-cols-lg-3 row-cols-sm-2 row-cols-1 justify-content-center">

                    @foreach ($categoriasAjuda as $categoriaLinha)

                        <div class="col">
                            <div class="feature-item widget widget-category">
                                <div class="feature-inner">
                                    <div class="feature-thumb" style="font-size: 50px;">
                                        @if ($categoriaLinha->icone != '')
                                            {!! $categoriaLinha->icone !!}
                                        @else
                                            <i class="icofont-learn"></i>
                                        @endif
                                    </div>
                                    <div class="feature-content">
                                        <a>
                                            <h5>{{ $categoriaLinha->nome }}</h5>
                                        </a>
                                        <a href="{{ route('site.verAjuda', [ $categoriaLinha->telas[0]->id, Str::slug( $categoriaLinha->telas[0]->nome, '-') . '.html']  ) }}" class="lab-btn-text">Conhecer
                                            <span></span></a>
                                    </div>
                                </div>
                                <ul class="widget-wrapper">
                                    @foreach ($categoriaLinha->telas as $linha)
                                        <li>
                                            <a href="{{ route('site.verAjuda', [$linha->id, Str::slug($linha->nome, '-') . '.html']) }}"
                                                class="d-flex flex-wrap justify-content-between"><span><i
                                                        class="icofont-double-right"></i>{{ $linha->nome }}</span></a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <!-- features section ending here -->

@endsection
