@extends('template.site')
@section('title', 'Ativação do Código')

@section('header')

@endsection

@section('footer')

@endsection

@section('conteudo')
    @php @session_start(); @endphp

    <!-- Page Header section start here -->
    <div class="pageheader-section" style="padding: 55px 0 92px !important">

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
                                        <div class="sftl-content">
                                            <h4>Video de auto ajuda:
                                            </h4>
                                            <p>
                                                A apresentação exibe todo o processo de como você ativará e acessará a plataforma!
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="stu-feed-bottom">
                                    @if (isset($_SESSION['ativacao_start']) and $_SESSION['ativacao_start']['matricula']->id != null)
                                        <form style="padding-top: 12px !important" class="newsletter-form"
                                            action="{{ route('site.cancelarAtivacao') }}" method="post">
                                            @csrf
                                            <input type="text" maxlength="15" minlength="15" name="codigo"
                                                value="{{ $_SESSION['ativacao_start']['matricula']->ativacao }}" readonly
                                                placeholder="Digite aqui o seu código de Ativação">
                                            <button type="submit" class="bg-danger">Cancelar</button>
                                        </form>
                                    @else
                                        <h4>Ativar Código: </h4 >
                                        <p class="desc">No campo abaixo insira o seu código de ativação do curso e
                                            começe a faze-lo agora mesmo.</p>
                                        <form style="padding-top: 12px !important" class="newsletter-form"
                                            action="{{ route('site.ativacaoCodigo') }}" method="post">
                                            @csrf
                                            <input type="text" maxlength="15" minlength="15" name="codigo"
                                                value="{{ old('codigo') }}"
                                                placeholder="Digite aqui o seu código de Ativação">
                                            <button type="submit"
                                                style="background: #66b54b !important; color: #fff !important;">Ativar
                                                Código</button>
                                        </form>
                                    @endif
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
