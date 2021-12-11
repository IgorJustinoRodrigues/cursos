<!DOCTYPE html>
<html lang="pt-br" dir="ltr" {{ @session_start() }}>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>

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
                <nav id="default-navbar" class="navbar navbar-expand navbar-dark bg-primary m-0">
                    <div class="container-fluid">
                        <!-- Toggle sidebar -->
                        <button class="navbar-toggler d-block" data-toggle="sidebar" type="button">
                            <span class="material-icons">menu</span>
                        </button>

                        <!-- Brand -->
                        <a href="student-dashboard.html" class="navbar-brand">
                            <span class="d-none d-xs-md-block">Start+</span>
                        </a>

                        <div class="flex"></div>

                        <!-- Menu -->
                        <ul class="nav navbar-nav flex-nowrap d-none d-lg-flex">
                            <li class="nav-item">
                                <a class="nav-link" href="student-help-center.html">Ajuda</a>
                            </li>
                        </ul>

                        <!-- Menu -->
                        <ul class="nav navbar-nav flex-nowrap">
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
                                        src="{{ URL::asset('template/images/people/50/guy-6.jpg') }}" alt="Avatar"
                                        class="rounded-circle" width="40"></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="student-account-edit.html">
                                        <i class="material-icons">edit</i> Editar Conta
                                    </a>
                                    <a class="dropdown-item" href="student-profile.html">
                                        <i class="material-icons">person</i> Perfil
                                    </a>
                                    <a class="dropdown-item" href="guest-login.html">
                                        <i class="material-icons">lock</i> Sair
                                    </a>
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
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="student-dashboard.html">Início</a></li>
                            <li class="breadcrumb-item"><a href="student-browse-courses.html">Meus Cursos</a></li>
                            <li class="breadcrumb-item active">Nome do Curso</li>
                        </ol>
                        <h1 class="h2">Nome do Curso</h1>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item"
                                            src="https://player.vimeo.com/video/97243285?title=0&amp;byline=0&amp;portrait=0"
                                            allowfullscreen=""></iframe>
                                    </div>
                                    <div class="card-body">
                                        Breve descrição da Aula, com informações adicionais.
                                    </div>
                                </div>

                                <!-- Lessons -->
                                <ul class="card list-group list-group-fit">
                                    <li class="list-group-item">
                                        <div class="media">
                                            <div class="media-left">
                                                <div class="text-muted">1.</div>
                                            </div>
                                            <div class="media-body">
                                                <a href="#">Introdução</a>
                                            </div>
                                            <div class="media-right">
                                                <small class="text-muted-light">2:03</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item active">
                                        <div class="media">
                                            <div class="media-left">2.</div>
                                            <div class="media-body">
                                                <a class="text-white" href="#">Aula 2</a>
                                            </div>
                                            <div class="media-right">
                                                <small>25:01</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="media">
                                            <div class="media-left">
                                                <div class="text-muted">3.</div>
                                            </div>
                                            <div class="media-body">
                                                <a href="#">Aula 3</a>
                                            </div>
                                            <div class="media-right">
                                                <small class="text-muted-light">12:10</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="media">
                                            <div class="media-left">
                                                <div class="text-muted">4.</div>
                                            </div>
                                            <div class="media-body">
                                                <div class="text-muted-light">Aula 4</div>
                                            </div>
                                            <div class="media-right">
                                                <small class="text-muted-light">10:10</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="media">
                                            <div class="media-left">
                                                <div class="text-muted">6.</div>
                                            </div>
                                            <div class="media-body">
                                                <div class="text-muted-light">Avaliação</div>
                                            </div>
                                            <div class="media-right">
                                                <small class="text-muted-light">5:00</small>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p>
                                            <a href="student-cart.html" class="btn btn-success btn-block flex-column">
                                                <i class="material-icons" style="font-size: 20px">cloud_download</i> Baixar Conteúdo Auxiliar
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <div class="media align-items-center">
                                            <div class="media-left">
                                                <img src="{{ URL::asset('template/images/people/110/guy-6.jpg') }}"
                                                    alt="About Adrian" width="50" class="rounded-circle">
                                            </div>
                                            <div class="media-body">
                                                <h4 class="card-title"><a href="student-profile.html">Nome do Professor</a></h4>
                                                <p class="card-subtitle">Professor</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p>Descrição Professor</p>
                                        <a href="" class="btn btn-light"><i class="fab fa-facebook"></i></a>
                                        <a href="" class="btn btn-light"><i class="fab fa-instagram"></i></a>
                                    </div>
                                </div>
                                <div class="card">
                                    <ul class="list-group list-group-fit">
                                        <li class="list-group-item">
                                            <div class="media align-items-center">
                                                <div class="media-left">
                                                    <i class="material-icons text-muted-light">assessment</i>
                                                </div>
                                                <div class="media-body">
                                                    Tempo de curso
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="media align-items-center">
                                                <div class="media-left">
                                                    <i class="material-icons text-muted-light">schedule</i>
                                                </div>
                                                <div class="media-body">
                                                    2 <small class="text-muted">hrs</small> &nbsp; 26 <small
                                                        class="text-muted">min</small>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Avalie sua aula</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="rating">
                                            <i class="material-icons">star</i>
                                            <i class="material-icons">star</i>
                                            <i class="material-icons">star</i>
                                            <i class="material-icons">star</i>
                                            <i class="material-icons">star_border</i>
                                        </div>
                                        <small class="text-muted">Média 4.5</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="mdk-drawer js-mdk-drawer" id="default-drawer">
                    <div class="mdk-drawer__content ">
                        <div class="sidebar sidebar-left sidebar-dark bg-dark o-hidden" data-perfect-scrollbar>
                            <div class="sidebar-p-y">
                                <!-- Account menu -->
                                <div class="sidebar-heading">Conta</div>
                                <ul class="sidebar-menu">
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button sidebar-js-collapse" data-toggle="collapse"
                                            href="#account_menu">
                                            <i
                                                class="sidebar-menu-icon sidebar-menu-icon--left material-icons">person_outline</i>
                                            Minha conta
                                            <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                        </a>
                                        <ul class="sidebar-submenu sm-indent collapse" id="account_menu">
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button" href="student-account-edit.html">
                                                    <span class="sidebar-menu-text">Editar Informações</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="student-browse-courses.html">
                                            <i
                                                class="sidebar-menu-icon sidebar-menu-icon--left material-icons">comment</i>
                                                Chat
                                        </a>
                                    </li>
                                </ul>
                                <div class="sidebar-heading">Cursos</div>
                                <ul class="sidebar-menu sm-active-button-bg">
                                    <li class="sidebar-menu-item active">
                                        <a class="sidebar-menu-button" href="student-view-course.html">
                                            <i
                                                class="sidebar-menu-icon sidebar-menu-icon--left material-icons">import_contacts</i>
                                                Meus Cursos
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="student-help-center.html">
                                            <i
                                                class="sidebar-menu-icon sidebar-menu-icon--left material-icons">live_help</i>
                                            Preciso de Ajuda
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ URL::asset('template/vendor/jquery.min.js') }}"></script>

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

</body>

</html>
