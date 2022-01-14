<!DOCTYPE html>
<html lang="pt-br" dir="ltr" {{ @session_start() }}>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{ URL::asset('site/images/x-icon.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ URL::asset('site/css/animate.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('site/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('site/css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('site/css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('site/css/lightcase.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('site/css/style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('site/css/telas/style.css') }}">

    @yield('header')
    <!-- jQuery -->

    <script src="{{ URL::asset('site/js/jquery.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('template/css/lobibox.min.css') }}" />
    <script src="{{ URL::asset('template/js/lobibox.js') }}"></script>
</head>

<body>

    <!-- preloader start here -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- preloader ending here -->


    <!-- scrollToTop start here -->
    <a href="#" class="scrollToTop"><i class="icofont-rounded-up"></i></a>
    <!-- scrollToTop ending here -->


    <!-- header section start here -->
    <header class="header-section">
        <div class="header-top">
            <div class="container">
                <div class="header-top-area">
                    <ul class="lab-ul left">
                        <li>
                            <i class="icofont-ui-call"></i> <span>+800-123-4567 6587</span>
                        </li>
                        <li>
                            <i class="icofont-location-pin"></i> Brasil, Carmo do Rio Verde / Ceres
                        </li>
                    </ul>
                    <ul class="lab-ul social-icons d-flex align-items-center">
                        <li>
                            <p>Encontre-nos no : </p>
                        </li>
                        <li><a href="#" class="fb"><i class="icofont-facebook-messenger"></i></a></li>
                        <li><a href="#" class=""><i class="icofont-brand-whatsapp"></i></a></li>
                        <li><a href="#"><i class="icofont-instagram"></i></a></li>
                        <li><a href="#" class="vimeo"><i class="icofont-vimeo"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container">
                <div class="header-wrapper">
                    <div class="logo">
                        <a href="{{ route('inicio') }}"><img src="{{ URL::asset('site/images/logo/01.png') }}"
                                alt="logo"></a>
                    </div>
                    <div class="menu-area">
                        <div class="menu">
                            <ul class="lab-ul">
                                <li>
                                    <a href="{{ route('inicio') }}">Início</a>
                                    <ul class="lab-ul">
                                        <li><a href="{{ route('site.ativacaoCodigo') }}">Primeira Ativação do
                                                código?</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="{{ route('site.cursos') }}">Cursos</a>
                                    <ul class="lab-ul">
                                        @foreach ($categoriasMenu as $linha)
                                        <li><a href="{{ route('site.cursos') }}">{{$linha->nome}}</a></li>                                            
                                        @endforeach
                                    </ul>
                                </li>
                                <li>
                                    <a href="#0">Acesso</a>
                                    <ul class="lab-ul">
                                        <li><a href="index-2.html">Acesso Vendedor</a></li>
                                        <li><a href="{{ route('acessoParceiro') }}">Acesso Parceiro</a></li>
                                        <li><a href="{{ route('acessoAdmin') }}">Acesso Administrador</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('site.suporte') }}">Suporte</a></li>
                            </ul>
                        </div>

                        <a href="{{ route('acessoAluno') }}" class="login"><i class="icofont-user"></i>
                            <span>ACESSO DE ALUNO</span> </a>

                        <!-- toggle icons -->
                        <div class="header-bar d-lg-none">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="ellepsis-bar d-lg-none">
                            <i class="icofont-info-square"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header section ending here -->

    @yield('conteudo')

    <!-- footer -->
    <div class="news-footer-wrap">
        <div class="fs-shape">
            <img src="{{ URL::asset('site/images/shape-img/03.png') }}" alt="fst" class="fst-1">
            <img src="{{ URL::asset('site/images/shape-img/04.png') }}" alt="fst" class="fst-2">
        </div>
        <!-- Newsletter Section Start Here -->
        <div class="news-letter">
            <div class="container">
                <div class="section-wrapper">
                    <div class="news-title">
                        <h3>Quer que enviemos um e-mail sobre ofertas especiais e atualizações?</h3>
                    </div>
                    <div class="news-form">
                        <form action="/">
                            <div class="nf-list">
                                <input type="email" name="email" placeholder="Digite o Seu Email">
                                <input type="submit" name="submit" value="Inscrever-se">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Newsletter Section Ending Here -->

        <!-- Footer Section Start Here -->
        <footer>
            <div class="footer-top padding-tb pt-0">
                <div class="container">
                    <div class="row g-4 row-cols-xl-4 row-cols-md-2 row-cols-1 justify-content-center">
                        <div class="col">
                            <div class="footer-item">
                                <div class="footer-inner">
                                    <div class="footer-content">
                                        <div class="title">
                                            <h4>Links</h4>
                                        </div>
                                        <div class="content">
                                            <ul class="lab-ul">
                                                <li><a href="#">Sobre Nós</a></li>
                                                <li><a href="#">Cursos</a></li>
                                                <li><a href="#">Novidades</a></li>
                                                <li><a href="#">Contato</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="footer-item">
                                <div class="footer-inner">
                                    <div class="footer-content">
                                        <div class="title">
                                            <h4>Contato social</h4>
                                        </div>
                                        <div class="content">
                                            <ul class="lab-ul">
                                                <li><a href="#">Facebook</a></li>
                                                <li><a href="#">WhatsApp</a></li>
                                                <li><a href="#">Instagram</a></li>
                                                <li><a href="#">YouTube</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="footer-item">
                                <div class="footer-inner">
                                    <div class="footer-content">
                                        <div class="title">
                                            <h4>Nosso Suporte</h4>
                                        </div>
                                        <div class="content">
                                            <ul class="lab-ul">
                                                <li><a href="#">Suporte Vendedor</a></li>
                                                <li><a href="#">Suporte Parceiro</a></li>
                                                <li><a href="#">Contatar Suporte</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom style-2">
                <div class="container">
                    <div class="section-wrapper">
                        <p>&copy; 2021 <a href="index.html">Edukon</a> Designed by <a
                                href="https://themeforest.net/user/CodexCoder" target="_blank">CodexCoder</a> </p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer Section Ending Here -->
    </div>
    <!-- footer -->


    <script src="{{ URL::asset('site/js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('site/js/swiper.min.js') }}"></script>
    <script src="{{ URL::asset('site/js/progress.js') }}"></script>
    <script src="{{ URL::asset('site/js/lightcase.js') }}"></script>
    <script src="{{ URL::asset('site/js/counter-up.js') }}"></script>
    <script src="{{ URL::asset('site/js/isotope.pkgd.js') }}"></script>
    <script src="{{ URL::asset('site/js/functions.js') }}"></script>
    @yield('footer')
    <script>
        @if (session('padrao'))
            Lobibox.notify('info', {
            size: 'mini',
            sound: false,
            icon: false,
            position: 'top right',
            msg: "{{ session('padrao') }}"
            });
        @endif
        @if (session('atencao'))
            Lobibox.notify('warning', {
            size: 'mini',
            sound: false,
            icon: false,
            position: 'top right',
            msg: "{{ session('atencao') }}"
            });
        @endif
        @if (session('sucesso'))
            Lobibox.notify('success', {
            size: 'mini',
            sound: false,
            icon: false,
            position: 'top right',
            msg: "{{ session('sucesso') }}"
            });
        @endif
        @if (session('erro'))
            Lobibox.notify('error', {
            size: 'mini',
            sound: false,
            icon: false,
            position: 'top right',
            msg: "{{ session('erro') }}"
            });
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                Lobibox.notify('error', {
                size: 'mini',
                sound: false,
                icon: false,
                position: 'top right',
                msg: "{{ $error }}"
                });
            @endforeach
        @endif
    </script>
</body>

</html>
