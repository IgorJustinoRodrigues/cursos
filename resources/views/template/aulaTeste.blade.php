<!DOCTYPE html>
<html lang="pt-br" dir="ltr" {{ @session_start() }}>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{ URL::asset('imagem/x-icon.png') }}" type="image/x-icon">
    <!-- Prevent the demo from appearing in search engines (REMOVE THIS) -->
    <meta name="robots" content="noindex">

    <!-- Custom Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Oswald:400,500,700%7CRoboto:400,500%7CRoboto:400,500&display=swap"
        rel="stylesheet">

    <!-- Perfect Scrollbar -->
    <link type="text/css" href="{{ URL::asset('template/vendor/perfect-scrollbar.css') }}" rel="stylesheet">

    <!-- Material Design Icons -->
    <link type="text/css" href="{{ URL::asset('template/css/material-icons.css') }}" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link type="text/css" href="{{ URL::asset('template/css/fontawesome.css') }}" rel="stylesheet">

    <!-- Preloader -->
    <link type="text/css" href="{{ URL::asset('template/vendor/spinkit.css') }}" rel="stylesheet">

    <!-- App CSS -->
    <link type="text/css" href="{{ URL::asset('template/css/app.css') }}" rel="stylesheet">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/fontawesome/4.5.0/css/font-awesome.min.css">

    <link type="text/css" href="{{ URL::asset('telas/ini.css') }}" rel="stylesheet">

    @yield('header')
    <!-- jQuery -->
    <script src="{{ URL::asset('template/vendor/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('template/css/lobibox.min.css') }}" />
    <script src="{{ URL::asset('template/js/lobibox.js') }}"></script>
</head>

<body class=" fixed-layout">
    <div class="preloader">
        <div class="sk-bounce">
            <div class="sk-bounce-dot"></div>
            <div class="sk-bounce-dot"></div>
        </div>
    </div>

    <!-- Header Layout -->
    <div class="mdk-header-layout js-mdk-header-layout" data-domfactory-upgraded="mdk-header-layout">

        <!-- Header -->

        <div id="header" class="mdk-header bg-dark js-mdk-header m-0" data-fixed="" data-effects="waterfall"
            data-retarget-mouse-scroll="" data-domfactory-upgraded="mdk-header"
            style="padding-top: 64px; transform: translate3d(0px, 0px, 0px);">
            <div class="mdk-header__bg">
                <div class="mdk-header__bg-front"></div>
                <div class="mdk-header__bg-rear"></div>
            </div>
            <div class="mdk-header__content">

                <!-- Navbar -->
                <nav id="default-navbar"
                    class="navbar navbar-expand navbar-dark bg-primary m-0 mdk-header--fixed mdk-header--shadow"
                    data-primary="data-primary"
                    style="transform: translate3d(0px, 0px, 0px); background-color: #7bbf4a !important">
                    <div style="margin: auto">

                        <!-- Brand -->
                        <a href="{{ route('painelAluno') }}" class="navbar-brand">
                            <img src="{{ URL::asset('imagem/Logo.svg') }}" style="width: 200px;"
                                class="mr-2">
                        </a>

                    </div>
                </nav>
                <!-- // END Navbar -->

            </div>
        </div>

        <!-- // END Header -->

        <!-- Header Layout Content -->
        <div class="mdk-header-layout__content d-flex flex-column" style="padding-top: 64px;">

            <div class="page__header">
                <div class="navbar bg-dark navbar-dark navbar-expand-sm d-none2 d-md-flex2">
                    <div class="container text-white text-uppercase">
                        AULA TESTE DO CURSO {{ $curso->nome }}
                    </div>
                </div>
            </div>

            <div class="page ">

                <div class="container page__container">
                    <div class="row">
                        <div class="col-md-8 mb-2">
                            <div class="card">
                                @if($aula->tipo == 1)
                                <div class="embed-responsive embed-responsive-16by9">
                                    {!! $aula->video !!}
                                </div>
                                @endif
                                <div class="card-body">
                                    <b>
                                        {!! app(App\Http\Controllers\AulaController::class)->tipo($aula->tipo, $aula->avaliacao, true) !!} {{ $aula->nome }}
                                    </b>
                                    <small class="text-muted-light">
                                        - {{ app(App\Services\Services::class)->minuto_hora($aula->duracao) }}
                                    </small>
                                    <hr>
                                    {{ $aula->descricao }}
                                </div>
                            </div>
                            @if (trim($aula->texto) != '<p><br></p>' and $aula->texto != null)
                                <div class="card">
                                    <div class="card-body">
                                        {!! $aula->texto !!}
                                    </div>
                                </div>
                            @endif

                        </div>
                        <div class="col-md-4">
                            <div class="card" id="div-concluir">
                                <div class="card-body text-center">
                                    <a href="{{ route('site.lerCurso', [$curso->id, Str::slug($curso->nome) . '.html']) }}" class="btn btn-success btn-block">
                                        SAIR DA AULA TESTE
                                    </a>
                                </div>
                            </div>

                            @if (count($anexos) > 0)
                                <div class="card">
                                    <div class="card-body text-center">
                                        <a class="btn btn-primary btn-block"> Conteúdos Auxiliares
                                        </a>
                                    </div>
                                    <ul class="card list-group list-group-fit">
                                        @foreach ($anexos as $linha)
                                            <li class="list-group-item">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <div class="text-muted-light">{{ $linha->nome }}</div>
                                                    </div>
                                                    <div class="media-right">
                                                        <a href="{{ URL::asset('storage/' . $linha->arquivo) }}"
                                                            download="{{ $linha->nome }}" class="btn btn-success">
                                                            <i class="material-icons mr-1">file_download</i> Baixar
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card">
                                <div class="card-header">
                                    <div class="media align-items-center">
                                        <div class="media-left">
                                            @if ($professor->avatar != '')
                                                <img src="{{ URL::asset('storage/' . $professor->avatar) }}"
                                                    width="50" class="rounded-circle">
                                            @else
                                                <img src="{{ URL::asset('storage/avatarProfessor/padrao.png') }}"
                                                    width="50" class="rounded-circle">
                                            @endif
                                        </div>
                                        <div class="media-body">
                                            <h4 class="card-title"><a>{{ $professor->nome }}</a></h4>
                                            <p class="card-subtitle">
                                                @if ($curso->cooprodutor)
                                                    Coprodução: {{ $curso->cooprodutor }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>{!! $professor->curriculo !!}</p>
                                    @if ($professor->email)
                                        <a href="mailto:{{ $professor->email }}" target="_blank"
                                            class="btn btn-light"><i class="fas fa-envelope"></i></a>
                                    @endif
                                    @if ($professor->facebook)
                                        <a href="{{ $professor->facebook }}" target="_blank"
                                            class="btn btn-light"><i class="fab fa-facebook"></i></a>
                                    @endif
                                    @if ($professor->instagram)
                                        <a href="{{ $professor->instagram }}" target="_blank"
                                            class="btn btn-light"><i class="fab fa-instagram"></i></a>
                                    @endif
                                    @if ($professor->linkedin)
                                        <a href="{{ $professor->linkedin }}" target="_blank"
                                            class="btn btn-light"><i class="fab fa-linkedin"></i></a>
                                    @endif
                                    @if ($professor->site)
                                        <a href="{{ $professor->site }}" target="_blank" class="btn btn-light"><i
                                                class="fas fa-globe"></i></a>
                                    @endif
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <h4 class="card-title">
                                                {{ $curso->nome }}
                                            </h4>
                                            @if ($curso->imagem != '')
                                                <img src="{{ URL::asset('storage/' . $curso->imagem) }}" width="100%">
                                            @else
                                                <img src="{{ URL::asset('storage/imagemCurso/padrao.png') }}"
                                                    width="100%">
                                            @endif
                                            <ul class="list-group list-group-fit mb-0">
                                                @php $i = 1; @endphp
                                                @foreach ($aulas as $linha)
                                                    <li class="list-group-item">
                                                        <div class="media">
                                                            <div class="media-left">
                                                                <div class="text-muted-light">{{ $i }}.
                                                                </div>
                                                            </div>
                                                            <small class="text-muted-light">
                                                                {!! app(App\Http\Controllers\AulaController::class)->tipo($linha->tipo, $linha->avaliacao, true) !!}
                                                                {{ $linha->nome }}
                                                                <br>
                                                                {{ app(App\Services\Services::class)->minuto_hora($linha->duracao) }}
                                                            </small>
                                                        </div>
                                                    </li>
                                                    @php $i++ @endphp
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container page__container">
                    <div class="footer">
                        <p>Todos os direitos reservado Faça Mais Brasil &copy; {{ date('Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- // END Header Layout Content -->

    </div>
    <!-- // END Header Layout -->
    <!-- Bootstrap -->
    <script src="{{ URL::asset('template/vendor/popper.min.js') }}"></script>
    <script src="{{ URL::asset('template/vendor/bootstrap.min.js') }}"></script>

    <!-- Perfect Scrollbar -->
    <script src="{{ URL::asset('template/vendor/perfect-scrollbar.min.js') }}"></script>

    <!-- MDK -->
    <script src="{{ URL::asset('template/vendor/dom-factory.js') }}"></script>
    <script src="{{ URL::asset('template/vendor/material-design-kit.js') }}"></script>

    <!-- App JS -->
    <script src="{{ URL::asset('template/js/app.js') }}"></script>

    <!-- Bootstrap -->
    <script src="{{ URL::asset('template/vendor/popper.min.js') }}"></script>
    <script src="{{ URL::asset('telas/ini.js') }}"></script>
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
