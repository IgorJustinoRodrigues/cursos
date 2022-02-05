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

    <style>
        .newsletters-section::after {
            bottom: 0;
            left: 0;
            background: url({{ URL::asset('site/images/shape-img/06.png') }}) no-repeat;
            background-position: center;
            background-size: cover
        }


        .newsletters-section {
            background: #2073b3 !important;
        }

        .texto-branco {
            color: #ffffff !important;
        }

        .section-header>p {
            color: #dbdbdb !important;
        }

        .link-rodape {
            text-align: right;
        }

        @media (max-width: 576px) {
            .link-rodape {
                text-align: center;
            }

            .link-rodape>a {
                margin-left: 20px;
                margin-right: 20px
            }

        }

        .link-rodape>a {
            margin-left: 20px
        }

    </style>
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
                            <i class="icofont-ui-call"></i> <span>0800 123 456 789</span>
                        </li>
                    </ul>
                    <ul class="lab-ul social-icons d-flex align-items-center">
                        <li>
                            <p>Encontre-nos no : </p>
                        </li>
                        <li><a href="#" class="fb"><i class="icofont-facebook"></i></a></li>
                        <li><a href="#" class=""><i class="icofont-brand-whatsapp"></i></a></li>
                        <li><a href="#"><i class="icofont-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container">
                <div class="header-wrapper">
                    <div class="logo">
                        <a href="{{ route('inicio') }}"><img src="{{ URL::asset('site/images/logo/Logo.svg') }}"
                                alt="logo" style="max-width: 250px"></a>
                    </div>
                    <div class="menu-area">
                        <div class="menu">
                            <ul class="lab-ul">
                                <li>
                                    <a href="{{ route('inicio') }}">Início</a>
                                    <ul class="lab-ul">
                                        <li><a href="{{ route('site.comoAtivarCodigo') }}">Primeira Ativação do
                                                código?</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript:void(0);">Cursos</a>
                                    <ul class="lab-ul">
                                        <li><a href="{{ route('site.cursos') }}">Todos os Cursos</a>
                                        </li>
                                        @foreach ($categoriasMenu as $linha)
                                            <li><a
                                                    href="{{ route('site.cursos', [$linha->id, $linha->nome]) }}">{{ $linha->nome }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">Acesso</a>
                                    <ul class="lab-ul">
                                        <li><a href="{{ route('acessoAluno') }}" target="_blank">Acesso Aluno</a>
                                        </li>
                                        <li><a href="{{ route('acessoVendedor') }}" target="_blank">Acesso
                                                Vendedor</a>
                                        </li>
                                        <li><a href="{{ route('acessoUnidade') }}" target="_blank">Acesso
                                                Unidade</a>
                                        </li>
                                        <li><a href="{{ route('acessoParceiro') }}" target="_blank">Acesso
                                                Parceiro</a></li>
                                        <li><a href="{{ route('acessoAdmin') }}" target="_blank">Acesso
                                                Administrador</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('site.ajuda') }}">Ajuda</a></li>
                            </ul>
                        </div>

                        @if (!isset($_SESSION['aluno_cursos_start']))
                            @if (isset($_SESSION['ativacao_start']))
                                <a href="{{ route('acessoAluno', 'cadastro') }}" class="login"><i
                                        class="icofont-user"></i>
                                    <span>ACESSO DE ALUNO</span> </a>

                            @else
                                <a href="{{ route('acessoAluno') }}" target="_blank" class="login"><i
                                        class="icofont-user"></i>
                                    <span>ACESSO DE ALUNO</span> </a>
                            @endif
                        @else
                            <a href="{{ route('painelAluno') }}" target="_blank" class="login"><i
                                    class="icofont-user"></i>
                                <span>{{ $_SESSION['aluno_cursos_start']->nome }}</span> </a>
                        @endif
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

    <!-- Newsletters Section Start Here -->
    <div class="newsletters-section padding-tb">
        <div class="container">
            <div class="newsletter-area">
                <div class="news-mass">
                    <i class="icofont-email"></i>
                </div>
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-6 col-12">
                        <div class="section-header">
                            <h2 class="title texto-branco">Assine a Newsletter</h2>
                            <p>Inscreva-se gratuitamente e receba a notificação e as últimas ofertas de nossos cursos.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="section-wrapper">
                            <h5 class="texto-branco">Informe o seu nome e e-mail</h5>

                            <div class="newsletter-form">
                                <input type="text" id="nome-newletters" placeholder="Informe o seu nome" required>
                                <input type="email" id="email-newletters" placeholder="Informe o seu e-mail" required>
                                <button class="btn lab-btn" id="btn-newletters" onclick="InserirNewsletter()" ><span>Me
                                        inscrever agora!</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Newsletters Section Ending Here -->




    <!-- Footer Section Start Here -->
    <footer class="style-2">
        <div class="footer-top padding-tb">
            <div class="container">
                <div class="row g-4 row-cols-xl-4 row-cols-sm-2 row-cols-1 justify-content-center">
                    <div class="col">
                        <div class="footer-item our-address">
                            <div class="footer-inner">
                                <div class="footer-content">
                                    <div class="title">
                                        <img src="{{ URL::asset('site/images/logo/Logo.svg') }}" alt="education">
                                    </div>
                                    <div class="content">
                                        <p>Venha fazer parte do futuro com o Faça Mais Brasil!</p>
                                        <ul class="lab-ul office-address">
                                            <li><i class="icofont-phone"></i>(62) 9 9999-9999</li>
                                            <li><i class="icofont-envelope"></i>contato.educamaisbrasil@gmail.com</li>
                                        </ul>
                                        <ul class="lab-ul social-icons">
                                            <li>
                                                <a href="#" class="facebook"><i class="icofont-facebook"></i></a>
                                            </li>
                                            <li>
                                                <a href="#" class="instagram"><i class="icofont-instagram"></i></a>
                                            </li>
                                            <li>
                                                <a href="#" class="whatsapp"><i class="icofont-whatsapp"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col text-center">
                        <div class="footer-item">
                            <div class="footer-inner">
                                <div class="footer-content">
                                    <div class="title">
                                        <h4>Conheça</h4>
                                    </div>
                                    <div class="content">
                                        <ul class="lab-ul">
                                            <li><a href="{{ route('site.cursos') }}">Todos os Cursos</a>
                                            </li>
                                            @foreach ($categoriasMenu as $linha)
                                                <li><a
                                                        href="{{ route('site.cursos', [$linha->id, $linha->nome]) }}">{{ $linha->nome }}</a>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col text-center">
                        <div class="footer-item">
                            <div class="footer-inner">
                                <div class="footer-content">
                                    <div class="title">
                                        <h4>Links Últeis</h4>
                                    </div>
                                    <div class="content">
                                        <ul class="lab-ul">
                                            <li><a href="#">Ajuda</a></li>
                                            <li><a href="#">Política de Privacidade</a></li>
                                            <li><a href="#">Termo de Uso</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p>Todos os direitos reservado Faça Mais Brasil &copy; {{ date('Y') }}</p>
                    </div>
                    <div class="col-md-6 link-rodape">
                        <a href="{{ route('acessoAdmin') }}">Administrador</a>
                        <a href="{{ route('acessoParceiro') }}">Parceiro</a>
                        <a href="{{ route('acessoUnidade') }}">Unidade</a>
                        <a href="{{ route('acessoVendedor') }}">Vendedor</a>
                        <a href="{{ route('acessoAluno') }}">Aluno</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section Ending Here -->

    <script src="{{ URL::asset('site/js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('site/js/swiper.min.js') }}"></script>
    <script src="{{ URL::asset('site/js/progress.js') }}"></script>
    <script src="{{ URL::asset('site/js/lightcase.js') }}"></script>
    <script src="{{ URL::asset('site/js/counter-up.js') }}"></script>
    <script src="{{ URL::asset('site/js/isotope.pkgd.js') }}"></script>
    <script src="{{ URL::asset('site/js/functions.js') }}"></script>

    @yield('footer')

    <script>
        function InserirNewsletter() {
            $("#btn-newletters").attr('disabled', true);

            var email = $("#email-newletters").val();
            var nome = $("#nome-newletters").val();

            if(nome == ''){
                Lobibox.notify('error', {
                    size: 'mini',
                    sound: false,
                    icon: false,
                    position: 'top right',
                    msg: "O campo nome é obrigatório."
                });
                
                $("#nome-newletters").focus();

                $("#btn-newletters").attr('disabled', false);
            
                return null;
            }

            
            if(email == ''){
                Lobibox.notify('error', {
                    size: 'mini',
                    sound: false,
                    icon: false,
                    position: 'top right',
                    msg: "O campo e-mail é obrigatório."
                });

                $("#email-newletters").focus();
                $("#btn-newletters").attr('disabled', false);
                
                return null;
            }

            $.ajax({
                type: 'post',
                url: "{{ route('InserirNewsletter') }}",
                data: {
                    email: email,
                    nome: nome,
                    _token: $("input[name='_token']").val()
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == '1') {
                        Lobibox.notify('success', {
                            size: 'mini',
                            sound: false,
                            icon: false,
                            position: 'top right',
                            msg: data.msg
                        });

                        $("#email-newletters").val('');
                        $("#nome-newletters").val('');

                    } else if(data.status == '2'){
                        Lobibox.notify('info', {
                            size: 'mini',
                            sound: false,
                            icon: false,
                            position: 'top right',
                            msg: data.msg
                        });
                        
                        $("#email-newletters").val('');
                        $("#nome-newletters").val('');
                    } else {
                        Lobibox.notify('warning', {
                            size: 'mini',
                            sound: false,
                            icon: false,
                            position: 'top right',
                            msg: data.msg
                        });
                    }

                    
                    $("#btn-newletters").attr('disabled', false);
                },
                error: function(error) {
                    
                    $.each(error.responseJSON['errors'], function(index, value) {
                        Lobibox.notify('error', {
                            size: 'mini',
                            sound: false,
                            icon: false,
                            position: 'top right',
                            msg: value
                        });
                    });
                    
                    $("#btn-newletters").attr('disabled', false);
                }
            });
        }
        
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
