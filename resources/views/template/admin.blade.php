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

    <link rel="stylesheet" href="{{ URL::asset('site/css/icofont.min.css') }}">

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

<body class=" layout-fluid">

    <div class="preloader">
        <div class="sk-bounce">
            <div class="sk-bounce-dot"></div>
            <div class="sk-bounce-dot"></div>
        </div>
    </div>

    <!-- Header Layout -->
    <div class="mdk-header-layout js-mdk-header-layout">
        <div id="header" data-fixed class="mdk-header js-mdk-header mb-0">
            <div class="mdk-header__content">

                <!-- Navbar -->
                <nav id="default-navbar" class="navbar navbar-expand navbar-dark bg-success m-0">
                    <div class="container-fluid">
                        <!-- Toggle sidebar -->
                        <button class="navbar-toggler d-block" data-toggle="sidebar" type="button">
                            <span class="material-icons">menu</span>
                        </button>

                        <!-- Brand -->
                        <a href="student-dashboard.html" class="navbar-brand">
                            <img src="{{ URL::asset('imagem/logo.svg') }}" style="width: 170px;"
                                class="mr-2" alt="LearnPlus">
                        </a>
                        <div class="flex"></div>

                        <!-- Menu -->
                        <ul class="nav navbar-nav flex-nowrap">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('inicio') }}" target="_blank">Site&nbsp;<i
                                        class="material-icons">remove_red_eye</i></a>
                            </li>
                            <!-- Notifications dropdown -->
                            <li class="nav-item dropdown dropdown-notifications dropdown-menu-sm-full">
                                <button class="nav-link btn-flush dropdown-toggle" type="button" data-toggle="dropdown"
                                    data-dropdown-disable-document-scroll data-caret="false">
                                    <i class="material-icons">notifications</i>
                                    <span class="badge badge-notifications badge-danger">2</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div data-perfect-scrollbar class="position-relative">
                                        <div class="dropdown-header"><strong>Messages</strong></div>
                                        <div class="list-group list-group-flush mb-0">

                                            <a href="student-messages.html"
                                                class="list-group-item list-group-item-action unread">
                                                <span class="d-flex align-items-center mb-1">
                                                    <small class="text-muted">5 minutes ago</small>

                                                    <span class="ml-auto unread-indicator bg-primary"></span>

                                                </span>
                                                <span class="d-flex">
                                                    <span class="avatar avatar-xs mr-2">
                                                        <img src="{{ URL::asset('template/images/people/110/woman-5.jpg') }}"
                                                            alt="people" class="avatar-img rounded-circle">
                                                    </span>
                                                    <span class="flex d-flex flex-column">
                                                        <strong>Michelle</strong>
                                                        <span class="text-black-70">Clients loved the new
                                                            design.</span>
                                                    </span>
                                                </span>
                                            </a>

                                            <a href="student-messages.html"
                                                class="list-group-item list-group-item-action unread">
                                                <span class="d-flex align-items-center mb-1">
                                                    <small class="text-muted">5 minutes ago</small>

                                                    <span class="ml-auto unread-indicator bg-primary"></span>

                                                </span>
                                                <span class="d-flex">
                                                    <span class="avatar avatar-xs mr-2">
                                                        <img src="{{ URL::asset('template/images/people/110/woman-5.jpg') }}"
                                                            alt="people" class="avatar-img rounded-circle">
                                                    </span>
                                                    <span class="flex d-flex flex-column">
                                                        <strong>Michelle</strong>
                                                        <span class="text-black-70">🔥 Superb job..</span>
                                                    </span>
                                                </span>
                                            </a>

                                        </div>

                                        <div class="dropdown-header"><strong>System notifications</strong></div>
                                        <div class="list-group list-group-flush mb-0">

                                            <a href="student-messages.html"
                                                class="list-group-item list-group-item-action border-left-3 border-left-danger">
                                                <span class="d-flex align-items-center mb-1">
                                                    <small class="text-muted">3 minutes ago</small>

                                                </span>
                                                <span class="d-flex">
                                                    <span class="avatar avatar-xs mr-2">
                                                        <span class="avatar-title rounded-circle bg-light">
                                                            <i
                                                                class="material-icons font-size-16pt text-danger">account_circle</i>
                                                        </span>
                                                    </span>
                                                    <span class="flex d-flex flex-column">

                                                        <span class="text-black-70">Your profile information has not
                                                            been synced correctly.</span>
                                                    </span>
                                                </span>
                                            </a>

                                            <a href="student-messages.html"
                                                class="list-group-item list-group-item-action">
                                                <span class="d-flex align-items-center mb-1">
                                                    <small class="text-muted">5 hours ago</small>

                                                </span>
                                                <span class="d-flex">
                                                    <span class="avatar avatar-xs mr-2">
                                                        <span class="avatar-title rounded-circle bg-light">
                                                            <i
                                                                class="material-icons font-size-16pt text-success">group_add</i>
                                                        </span>
                                                    </span>
                                                    <span class="flex d-flex flex-column">
                                                        <strong>Adrian. D</strong>
                                                        <span class="text-black-70">Wants to join your private
                                                            group.</span>
                                                    </span>
                                                </span>
                                            </a>

                                            <a href="student-messages.html"
                                                class="list-group-item list-group-item-action">
                                                <span class="d-flex align-items-center mb-1">
                                                    <small class="text-muted">1 day ago</small>

                                                </span>
                                                <span class="d-flex">
                                                    <span class="avatar avatar-xs mr-2">
                                                        <span class="avatar-title rounded-circle bg-light">
                                                            <i
                                                                class="material-icons font-size-16pt text-warning">storage</i>
                                                        </span>
                                                    </span>
                                                    <span class="flex d-flex flex-column">

                                                        <span class="text-black-70">Your deploy was successful.</span>
                                                    </span>
                                                </span>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!-- // END Notifications dropdown -->
                            <!-- User dropdown -->
                            <li class="nav-item dropdown ml-1 ml-md-3">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"><img
                                        src="{{ URL::asset('storage/' . $_SESSION['admin_cursos_start']['avatar_admin']) }}"
                                        alt="Avatar" class="rounded-circle" width="40"></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <p class="dropdown-item">
                                        {{ $_SESSION['admin_cursos_start']['nome_admin'] }}
                                    </p>
                                    <a class="dropdown-item" href="{{ route('painelAdmin') }}">
                                        <i class="material-icons">person</i> Perfil
                                    </a>
                                    <a class="dropdown-item"
                                        href="{{ route('adminEditar', $_SESSION['admin_cursos_start']['id_admin']) }}">
                                        <i class="material-icons">edit</i> Editar Conta
                                    </a>
                                    <a class="dropdown-item" href="{{ route('sairAdmin') }}">
                                        <i class="material-icons">lock</i> Sair
                                    </a>
                                    <p class="dropdown-item" style="font-size: 10px">
                                        Último acesso
                                        em:<br>{{ $_SESSION['admin_cursos_start']['ultimo_acesso_admin'] }}
                                    </p>
                                </div>
                            </li>
                            <!-- // END User dropdown -->

                        </ul>
                        <!-- // END Menu -->
                    </div>
                </nav>
                <!-- // END Navbar -->

            </div>
        </div>

        <!-- // END Header -->
        <!-- Header Layout Content -->
        <div class="mdk-header-layout__content">

            <div data-push data-responsive-width="992px" class="mdk-drawer-layout js-mdk-drawer-layout">
                <div class="mdk-drawer-layout__content page ">

                    <div class="container-fluid page__container">

                        @yield('conteudo')

                    </div>

                </div>

                <div class="mdk-drawer js-mdk-drawer" id="default-drawer">
                    <div class="mdk-drawer__content ">
                        <div class="sidebar sidebar-left sidebar-dark bg-dark o-hidden" data-perfect-scrollbar>
                            <div class="sidebar-p-y">
                                <!-- Account menu -->
                                <div class="sidebar-heading">Administrativo</div>
                                <ul class="sidebar-menu sm-active-button-bg">
                                    <li class="sidebar-menu-item @hasSection('menu-admin') active @endif">
                                        <a class="sidebar-menu-button sidebar-js-collapse" data-toggle="collapse"
                                            href="#account_menu">
                                            <i
                                                class="sidebar-menu-icon sidebar-menu-icon--left material-icons">person_outline</i>
                                            Administradores
                                            <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                        </a>
                                        <ul class="sidebar-submenu sm-indent collapse" id="account_menu">
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button" href="{{ route('adminIndex') }}">
                                                    <span class="sidebar-menu-text">Listar</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button" href="{{ route('adminCadastro') }}">
                                                    <span class="sidebar-menu-text">Cadastro</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>

                                <div class="sidebar-heading">Lojas</div>
                                <ul class="sidebar-menu sm-active-button-bg">
                                    <li class="sidebar-menu-item @hasSection('menu-parceiro') active @endif">
                                        <a class="sidebar-menu-button sidebar-js-collapse" data-toggle="collapse"
                                            href="#menuParceiro">
                                            <i
                                                class="sidebar-menu-icon sidebar-menu-icon--left material-icons">supervised_user_circle</i>
                                            Parceiros
                                            <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                        </a>
                                        <ul class="sidebar-submenu sm-indent collapse" id="menuParceiro">
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button" href="{{ route('parceiroIndex') }}">
                                                    <span class="sidebar-menu-text">Listar</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button"
                                                    href="{{ route('parceiroCadastro') }}">
                                                    <span class="sidebar-menu-text">Cadastro</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-menu-item @hasSection('menu-unidade') active @endif">
                                        <a class="sidebar-menu-button sidebar-js-collapse" data-toggle="collapse"
                                            href="#menuUnidade">
                                            <i
                                                class="sidebar-menu-icon sidebar-menu-icon--left material-icons">domain</i>
                                            Unidades
                                            <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                        </a>
                                        <ul class="sidebar-submenu sm-indent collapse" id="menuUnidade">
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button" href="{{ route('unidadeIndex') }}">
                                                    <span class="sidebar-menu-text">Listar</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button"
                                                    href="{{ route('unidadeCadastro') }}">
                                                    <span class="sidebar-menu-text">Cadastro</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-menu-item @hasSection('menu-vendedor') active @endif">
                                        <a class="sidebar-menu-button sidebar-js-collapse" data-toggle="collapse"
                                            href="#menuVendedor">
                                            <i
                                                class="sidebar-menu-icon sidebar-menu-icon--left material-icons">perm_contact_calendar</i>
                                            Vendedor
                                            <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                        </a>
                                        <ul class="sidebar-submenu sm-indent collapse" id="menuVendedor">
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button" href="{{ route('vendedorIndex') }}">
                                                    <span class="sidebar-menu-text">Listar</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button"
                                                    href="{{ route('vendedorCadastro') }}">
                                                    <span class="sidebar-menu-text">Cadastro</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-menu-item @hasSection('menu-matricula') active @endif">
                                        <a class="sidebar-menu-button sidebar-js-collapse" data-toggle="collapse"
                                            href="#menuMatricula">
                                            <i
                                                class="sidebar-menu-icon sidebar-menu-icon--left material-icons">perm_contact_calendar</i>
                                            Matrícula
                                            <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                        </a>
                                        <ul class="sidebar-submenu sm-indent collapse" id="menuMatricula">
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button" href="{{ route('matriculaIndex') }}">
                                                    <span class="sidebar-menu-text">Listar</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button"
                                                    href="{{ route('matriculaCadastro') }}">
                                                    <span class="sidebar-menu-text">Cadastro</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>

                                <div class="sidebar-heading">Cursos</div>
                                <ul class="sidebar-menu sm-active-button-bg">
                                    <li class="sidebar-menu-item @hasSection('menu-curso') active @endif">
                                        <a class="sidebar-menu-button sidebar-js-collapse" data-toggle="collapse"
                                            href="#menuCurso">
                                            <i
                                                class="sidebar-menu-icon sidebar-menu-icon--left material-icons">supervised_user_circle</i>
                                            Curso
                                            <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                        </a>
                                        <ul class="sidebar-submenu sm-indent collapse" id="menuCurso">
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button" href="{{ route('cursoIndex') }}">
                                                    <span class="sidebar-menu-text">Listar</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button" href="{{ route('cursoCadastro') }}">
                                                    <span class="sidebar-menu-text">Cadastro</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-menu-item @hasSection('menu-categoriaCurso') active @endif">
                                        <a class="sidebar-menu-button sidebar-js-collapse" data-toggle="collapse"
                                            href="#menuCategoriaCurso">
                                            <i
                                                class="sidebar-menu-icon sidebar-menu-icon--left material-icons">dashboard_customize</i>
                                            Categoria de Curso
                                            <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                        </a>
                                        <ul class="sidebar-submenu sm-indent collapse" id="menuCategoriaCurso">
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button"
                                                    href="{{ route('categoriaCursoIndex') }}">
                                                    <span class="sidebar-menu-text">Listar</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button"
                                                    href="{{ route('categoriaCursoCadastro') }}">
                                                    <span class="sidebar-menu-text">Cadastro</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-menu-item @hasSection('menu-professor') active @endif">
                                        <a class="sidebar-menu-button sidebar-js-collapse" data-toggle="collapse"
                                            href="#menuProfessor">
                                            <i
                                                class="sidebar-menu-icon sidebar-menu-icon--left material-icons">person_pin</i>
                                            Professor
                                            <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                        </a>
                                        <ul class="sidebar-submenu sm-indent collapse" id="menuProfessor">
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button" href="{{ route('professorIndex') }}">
                                                    <span class="sidebar-menu-text">Listar</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button"
                                                    href="{{ route('professorCadastro') }}">
                                                    <span class="sidebar-menu-text">Cadastro</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <div class="sidebar-heading">Gerenciar</div>
                                <ul class="sidebar-menu sm-active-button-bg">
                                    <li class="sidebar-menu-item @hasSection('menu-aluno') active @endif">
                                        <a class="sidebar-menu-button sidebar-js-collapse" data-toggle="collapse"
                                            href="#menuAluno">
                                            <i
                                                class="sidebar-menu-icon sidebar-menu-icon--left material-icons">school</i>
                                            Alunos
                                            <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                        </a>
                                        <ul class="sidebar-submenu sm-indent collapse" id="menuAluno">
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button" href="{{ route('alunoIndex') }}">
                                                    <span class="sidebar-menu-text">Listar</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button" href="{{ route('alunoCadastro') }}">
                                                    <span class="sidebar-menu-text">Cadastro</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <div class="sidebar-heading">Newsletter</div>
                                <ul class="sidebar-menu sm-active-button-bg">
                                    <li class="sidebar-menu-item @hasSection('menu-newsletter') active @endif">
                                        <a class="sidebar-menu-button sidebar-js-collapse" data-toggle="collapse"
                                            href="#menuNewsletter">
                                            <i
                                                class="sidebar-menu-icon sidebar-menu-icon--left material-icons">mail</i>
                                            Newsletter
                                            <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                        </a>
                                        <ul class="sidebar-submenu sm-indent collapse" id="menuNewsletter">
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button" href="{{ route('newsletterIndex') }}">
                                                    <span class="sidebar-menu-text">Caixa de Entrada</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <div class="sidebar-heading">Ajuda</div>
                                <ul class="sidebar-menu sm-active-button-bg">
                                    <li class="sidebar-menu-item  @hasSection('menu-ajuda') active @endif">
                                        <a class="sidebar-menu-button sidebar-js-collapse" data-toggle="collapse"
                                            href="#menuAjuda">
                                            <i
                                                class="sidebar-menu-icon sidebar-menu-icon--left material-icons">lightbulb</i>
                                            Ajuda
                                            <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                        </a>
                                        <ul class="sidebar-submenu sm-indent collapse" id="menuAjuda">
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button" href="{{ route('ajudaIndex') }}">
                                                    <span class="sidebar-menu-text">Listar</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button" href="{{ route('ajudaCadastro') }}">
                                                    <span class="sidebar-menu-text">Cadastro</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-menu-item  @hasSection('menu-categoria-ajuda') active @endif">
                                        <a class="sidebar-menu-button sidebar-js-collapse" data-toggle="collapse"
                                            href="#menuCategoriaAjuda">
                                            <i
                                                class="sidebar-menu-icon sidebar-menu-icon--left material-icons">info</i>
                                            Categoria de Ajuda
                                            <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                        </a>
                                        <ul class="sidebar-submenu sm-indent collapse" id="menuCategoriaAjuda">
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button"
                                                    href="{{ route('categoriaAjudaIndex') }}">
                                                    <span class="sidebar-menu-text">Listar</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button"
                                                    href="{{ route('categoriaAjudaCadastro') }}">
                                                    <span class="sidebar-menu-text">Cadastro</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalConfirmacao" tabindex="-1" aria-labelledby="confirmacaoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmacaoLabel">Confirmação</h5>
                </div>
                <div class="modal-body" id="div-confirmacao">
                </div>
                <div class="modal-footer">
                    <a onclick="$('#modalConfirmacao').modal('hide');" class="btn btn-dark">Fechar</a>
                    <a id="link-confirmacao" class="btn btn-success">Confirmar</a>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Highlight.js -->
    <script src="{{ URL::asset('template/js/hljs.js') }}"></script>

    <!-- App Settings (safe to remove) -->
    <script src="{{ URL::asset('template/js/app-settings.js') }}"></script>

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
