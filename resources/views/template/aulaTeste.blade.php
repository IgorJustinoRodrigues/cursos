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
                    <div class="container text-w">
                        gjgh
                    </div>
                </div>
            </div>

            <div class="page ">

                <div class="container page__container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="fixed-instructor-dashboard.html">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <h1 class="h2">Dashboard</h1>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header d-flex align-items-center">
                                    <div class="flex">
                                        <h4 class="card-title">Earnings</h4>
                                        <p class="card-subtitle">Last 7 Days</p>
                                    </div>
                                    <a href="fixed-instructor-earnings.html" class="btn btn-sm btn-primary"><i
                                            class="material-icons">trending_up</i></a>
                                </div>
                                <div class="card-body">
                                    <div id="legend" class="chart-legend mt-0 mb-24pt justify-content-start"><span
                                            class="chart-legend-item"><i class="chart-legend-indicator"
                                                style="background-color: #2196F3"></i>Earnings</span></div>
                                    <div class="chart" style="height: 200px;">
                                        <div class="chartjs-size-monitor">
                                            <div class="chartjs-size-monitor-expand">
                                                <div class=""></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink">
                                                <div class=""></div>
                                            </div>
                                        </div>
                                        <canvas id="earningsChart"
                                            class="chart-canvas js-update-chart-bar chartjs-render-monitor"
                                            data-chart-legend="#legend" data-chart-line-background-color="primary"
                                            data-chart-prefix="$" data-chart-suffix="k"
                                            style="display: block; height: 200px; width: 500px;" width="625"
                                            height="250"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header d-flex align-items-center">
                                    <div class="flex">
                                        <h4 class="card-title">Transactions</h4>
                                        <p class="card-subtitle">Latest Transactions</p>
                                    </div>
                                    <a href="fixed-instructor-statement.html" class="btn btn-sm btn-primary"><i
                                            class="material-icons">receipt</i></a>
                                </div>
                                <div data-toggle="lists" data-lists-values="[
        &quot;js-lists-values-course&quot;, 
        &quot;js-lists-values-document&quot;,
        &quot;js-lists-values-amount&quot;,
        &quot;js-lists-values-date&quot;
      ]" data-lists-sort-by="js-lists-values-date" data-lists-sort-desc="true" class="table-responsive">
                                    <table class="table table-nowrap m-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th colspan="2">
                                                    <a href="javascript:void(0)" class="sort"
                                                        data-sort="js-lists-values-course">Course</a>
                                                    <a href="javascript:void(0)" class="sort"
                                                        data-sort="js-lists-values-document">Document</a>
                                                    <a href="javascript:void(0)" class="sort"
                                                        data-sort="js-lists-values-amount">Amount</a>
                                                    <a href="javascript:void(0)" class="sort desc"
                                                        data-sort="js-lists-values-date">Date</a>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                            <tr>
                                                <td>
                                                    <div class="media align-items-center">
                                                        <a href="fixed-instructor-course-edit.html"
                                                            class="avatar avatar-4by3 avatar-sm mr-3">
                                                            <img src="assets/images/gulp.png" alt="course"
                                                                class="avatar-img rounded">
                                                        </a>
                                                        <div class="media-body">
                                                            <a class="text-body js-lists-values-course"
                                                                href="fixed-instructor-course-edit.html"><strong>Learn
                                                                    Angular Fundamentals</strong></a><br>
                                                            <small class="text-muted mr-1">
                                                                Invoice
                                                                <a href="fixed-instructor-invoice.html"
                                                                    style="color: inherit;"
                                                                    class="js-lists-values-document">#8737</a> -
                                                                $<span class="js-lists-values-amount">89</span> USD
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <small class="text-muted text-uppercase js-lists-values-date">15 Nov
                                                        2018</small>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="media align-items-center">
                                                        <a href="fixed-instructor-course-edit.html"
                                                            class="avatar avatar-4by3 avatar-sm mr-3">
                                                            <img src="assets/images/github.png" alt="course"
                                                                class="avatar-img rounded">
                                                        </a>
                                                        <div class="media-body">
                                                            <a class="text-body js-lists-values-course"
                                                                href="fixed-instructor-course-edit.html"><strong>Introduction
                                                                    to TypeScript</strong></a><br>
                                                            <small class="text-muted mr-1">
                                                                Invoice
                                                                <a href="fixed-instructor-invoice.html"
                                                                    style="color: inherit;"
                                                                    class="js-lists-values-document">#8736</a> -
                                                                $<span class="js-lists-values-amount">89</span> USD
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <small class="text-muted text-uppercase js-lists-values-date">14 Nov
                                                        2018</small>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="media align-items-center">
                                                        <a href="fixed-instructor-course-edit.html"
                                                            class="avatar avatar-4by3 avatar-sm mr-3">
                                                            <img src="assets/images/vuejs.png" alt="course"
                                                                class="avatar-img rounded">
                                                        </a>
                                                        <div class="media-body">
                                                            <a class="text-body js-lists-values-course"
                                                                href="fixed-instructor-course-edit.html"><strong>Angular
                                                                    Unit Testing</strong></a><br>
                                                            <small class="text-muted mr-1">
                                                                Invoice
                                                                <a href="fixed-instructor-invoice.html"
                                                                    style="color: inherit;"
                                                                    class="js-lists-values-document">#8735</a> -
                                                                $<span class="js-lists-values-amount">89</span> USD
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <small class="text-muted text-uppercase js-lists-values-date">13 Nov
                                                        2018</small>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="media align-items-center">
                                                        <a href="fixed-instructor-course-edit.html"
                                                            class="avatar avatar-4by3 avatar-sm mr-3">
                                                            <img src="assets/images/vuejs.png" alt="course"
                                                                class="avatar-img rounded">
                                                        </a>
                                                        <div class="media-body">
                                                            <a class="text-body js-lists-values-course"
                                                                href="fixed-instructor-course-edit.html"><strong>Angular
                                                                    Routing In-Depth</strong></a><br>
                                                            <small class="text-muted mr-1">
                                                                Invoice
                                                                <a href="fixed-instructor-invoice.html"
                                                                    style="color: inherit;"
                                                                    class="js-lists-values-document">#8734</a> -
                                                                $<span class="js-lists-values-amount">89</span> USD
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <small class="text-muted text-uppercase js-lists-values-date">12 Nov
                                                        2018</small>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header d-flex align-items-center">
                                    <div class="flex">
                                        <h4 class="card-title">Sales today</h4>
                                        <p class="card-subtitle">by course</p>
                                    </div>
                                    <a class="btn btn-sm btn-primary"
                                        href="fixed-instructor-earnings.html">Earnings</a>
                                </div>
                                <ul class="list-group list-group-fit mb-0">
                                    <li class="list-group-item">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <a href="fixed-instructor-course-edit.html"
                                                    class="text-body"><strong>Basics of HTML</strong></a>
                                            </div>
                                            <div class="media-right">
                                                <div class="text-center">
                                                    <span class="badge badge-pill badge-primary">15</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <a href="fixed-instructor-course-edit.html"
                                                    class="text-body"><strong>Angular in Steps</strong></a>
                                            </div>
                                            <div class="media-right">
                                                <div class="text-center">
                                                    <span class="badge badge-pill badge-success">50</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <a href="fixed-instructor-course-edit.html"
                                                    class="text-body"><strong>Bootstrap Foundations</strong></a>
                                            </div>
                                            <div class="media-right">
                                                <div class="text-center">
                                                    <span class="badge badge-pill badge-warning">14</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <a href="fixed-instructor-course-edit.html"
                                                    class="text-body"><strong>GitHub Basics</strong></a>
                                            </div>
                                            <div class="media-right">
                                                <div class="text-center">
                                                    <span class="badge badge-pill  badge-danger ">14</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="card">
                                <div class="card-header d-flex align-items-center">
                                    <div class="flex">
                                        <h4 class="card-title">Comments</h4>
                                        <p class="card-subtitle">Latest comments</p>
                                    </div>
                                    <div class="text-right" style="min-width: 80px;">
                                        <a href="#" class="btn btn-outline-primary btn-sm"><i
                                                class="material-icons">keyboard_arrow_left</i></a>
                                        <a href="#" class="btn btn-outline-primary btn-sm"><i
                                                class="material-icons">keyboard_arrow_right</i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="#" class="avatar avatar-sm">
                                                <img src="assets/images/people/110/guy-9.jpg" alt="Guy"
                                                    class="avatar-img rounded-circle">
                                            </a>
                                        </div>
                                        <div class="media-body d-flex flex-column">
                                            <div class="d-flex align-items-center">
                                                <a href="fixed-instructor-profile.html"
                                                    class="text-body"><strong>Laza Bogdan</strong></a>
                                                <small class="ml-auto text-muted">27 min ago</small><br>
                                            </div>
                                            <span class="text-muted">on <a href="fixed-instructor-course-edit.html"
                                                    class="text-black-50" style="text-decoration: underline;">Data
                                                    Visualization With Chart.js</a></span>
                                            <p class="mt-1 mb-0 text-black-70">How can I load Charts on a page?</p>
                                        </div>
                                    </div>
                                    <div class="media ml-sm-32pt mt-3 border rounded p-3 bg-light">
                                        <div class="media-left">
                                            <a href="#" class="avatar avatar-sm">
                                                <img src="assets/images/people/110/guy-6.jpg" alt="Guy"
                                                    class="avatar-img rounded-circle">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <div class="d-flex align-items-center">
                                                <a href="fixed-instructor-profile.html"
                                                    class="text-body"><strong>FrontendMatter</strong></a>
                                                <small class="ml-auto text-muted">just now</small>
                                            </div>
                                            <p class="mt-1 mb-0 text-black-70">Hi Bogdan,<br> Thank you for purchasing
                                                our course! <br><br>Please have a look at the charts library
                                                documentation <a href="#">here</a> and follow the instructions.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <form action="#" id="message-reply">
                                        <div class="input-group input-group-merge">
                                            <input type="text" class="form-control form-control-appended" required=""
                                                placeholder="Quick Reply">
                                            <div class="input-group-append">
                                                <div class="input-group-text pr-2">
                                                    <button class="btn btn-flush" type="button"><i
                                                            class="material-icons">tag_faces</i></button>
                                                </div>
                                                <div class="input-group-text pl-0">
                                                    <div class="custom-file custom-file-naked d-flex"
                                                        style="width: 24px; overflow: hidden;">
                                                        <input type="file" class="custom-file-input" id="customFile">
                                                        <label class="custom-file-label" style="color: inherit;"
                                                            for="customFile">
                                                            <i class="material-icons">attach_file</i>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="input-group-text pl-0">
                                                    <button class="btn btn-flush" type="button"><i
                                                            class="material-icons">send</i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container page__container">
                    <div class="footer">
                        Copyright © 2016 - <a
                            href="http://themeforest.net/item/learnplus-learning-management-application/15287372?ref=mosaicpro">Purchase
                            LearnPlus</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- // END Header Layout Content -->

    </div>
    <!-- // END Header Layout -->

    <div class="mdk-drawer js-mdk-drawer" id="default-drawer" data-align="start" data-position="left"
        data-domfactory-upgraded="mdk-drawer">
        <div class="mdk-drawer__scrim" style=""></div>
        <div class="mdk-drawer__content " style="">
            <div class="sidebar sidebar-left sidebar-dark bg-dark o-hidden ps ps--active-y" data-perfect-scrollbar="">
                <div class="sidebar-p-y">
                    <div class="sidebar-heading">APPLICATIONS</div>
                    <ul class="sidebar-menu sm-active-button-bg">
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-button" href="fixed-student-dashboard.html">
                                <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">account_box</i>
                                Student
                            </a>
                        </li>
                        <li class="sidebar-menu-item active">
                            <a class="sidebar-menu-button" href="fixed-instructor-dashboard.html">
                                <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">school</i>
                                Instructor
                            </a>
                        </li>
                    </ul>
                    <!-- Account menu -->
                    <div class="sidebar-heading">Account</div>
                    <ul class="sidebar-menu">
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-button sidebar-js-collapse" data-toggle="collapse"
                                href="#account_menu">
                                <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">person_outline</i>
                                Account
                                <span class="ml-auto sidebar-menu-toggle-icon"></span>
                            </a>
                            <ul class="sidebar-submenu sm-indent collapse" id="account_menu">
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="guest-login.html">
                                        <span class="sidebar-menu-text">Login</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="guest-signup.html">
                                        <span class="sidebar-menu-text">Sign Up</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="guest-forgot-password.html">
                                        <span class="sidebar-menu-text">Forgot Password</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-instructor-account-edit.html">
                                        <span class="sidebar-menu-text">Edit Account</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-student-account-edit-basic.html">
                                        <span class="sidebar-menu-text">Basic Information</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-student-account-edit-profile.html">
                                        <span class="sidebar-menu-text">Profile &amp; Privacy</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button"
                                        href="fixed-student-account-billing-subscription.html">
                                        <span class="sidebar-menu-text">Subscription</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-student-account-billing-upgrade.html">
                                        <span class="sidebar-menu-text">Upgrade Account</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button"
                                        href="fixed-student-account-billing-payment-information.html">
                                        <span class="sidebar-menu-text">Payment Information</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-student-billing.html">
                                        <span class="sidebar-menu-text">Payment History</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-student-invoice.html">
                                        <span class="sidebar-menu-text">Student Invoice</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-instructor-invoice.html">
                                        <span class="sidebar-menu-text">Instructor Invoice</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-instructor-edit-invoice.html">
                                        <span class="sidebar-menu-text">Edit Invoice</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-button" data-toggle="collapse" href="#messages_menu">
                                <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">comment</i>
                                Messages
                                <span class="ml-auto sidebar-menu-toggle-icon"></span>
                            </a>
                            <ul class="sidebar-submenu sm-indent collapse" id="messages_menu">
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-instructor-messages.html">
                                        <span class="sidebar-menu-text">Conversation</span>
                                        <span
                                            class="sidebar-menu-badge badge badge-primary badge-notifications ml-auto">2</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-instructor-messages-2.html">
                                        <span class="sidebar-menu-text">Conversation - 2</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <div class="sidebar-heading">Instructor</div>
                    <ul class="sidebar-menu sm-active-button-bg">
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-button" href="fixed-instructor-courses.html">
                                <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">import_contacts</i>
                                Course Manager
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-button" href="fixed-instructor-quizzes.html">
                                <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">help</i> Quiz
                                Manager
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-button" href="fixed-instructor-earnings.html">
                                <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">trending_up</i>
                                Earnings
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-button" href="fixed-instructor-statement.html">
                                <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">receipt</i>
                                Statement
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-button" data-toggle="collapse" href="#forum_menu">
                                <i
                                    class="sidebar-menu-icon sidebar-menu-icon--left material-icons">chat_bubble_outline</i>
                                Community
                                <span class="ml-auto sidebar-menu-toggle-icon"></span>
                            </a>
                            <ul class="sidebar-submenu sm-indent collapse" id="forum_menu">
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-instructor-forum.html">
                                        <span class="sidebar-menu-text">Forum</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-instructor-forum-thread.html">
                                        <span class="sidebar-menu-text">Discussion</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-instructor-forum-ask.html">
                                        <span class="sidebar-menu-text">Ask Question</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-student-profile.html">
                                        <span class="sidebar-menu-text">Student Profile - Courses</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-student-profile-posts.html">
                                        <span class="sidebar-menu-text">Student Profile - Posts</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-instructor-profile.html">
                                        <span class="sidebar-menu-text">Instructor Profile</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-button" href="fixed-instructor-help-center.html">
                                <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">live_help</i> Help
                                Center
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-button" href="guest-login.html">
                                <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">lock_open</i>
                                Logout
                            </a>
                        </li>
                    </ul>
                    <!-- Components menu -->
                    <div class="sidebar-heading">Components</div>
                    <ul class="sidebar-menu">
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-button sidebar-js-collapse" data-toggle="collapse"
                                href="#components_menu">
                                <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">tune</i>
                                Components
                                <span class="ml-auto sidebar-menu-toggle-icon"></span>
                            </a>
                            <ul class="sidebar-submenu sm-indent collapse" id="components_menu">
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-ui-avatars.html">
                                        <span class="sidebar-menu-text">Avatars</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-ui-forms.html">
                                        <span class="sidebar-menu-text">Forms</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-ui-loaders.html">
                                        <span class="sidebar-menu-text">Loaders</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-ui-tables.html">
                                        <span class="sidebar-menu-text">Tables</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-ui-cards.html">
                                        <span class="sidebar-menu-text">Cards</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-ui-tabs.html">
                                        <span class="sidebar-menu-text">Tabs</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-ui-icons.html">
                                        <span class="sidebar-menu-text">Icons</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-ui-buttons.html">
                                        <span class="sidebar-menu-text">Buttons</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-ui-alerts.html">
                                        <span class="sidebar-menu-text">Alerts</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-ui-badges.html">
                                        <span class="sidebar-menu-text">Badges</span>
                                    </a>
                                </li>
                                <!-- <li class="sidebar-menu-item">
    <a class="sidebar-menu-button" href="fixed-ui-modals.html">
      <span class="sidebar-menu-text">- Modals</span>
    </a>
  </li> -->
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-ui-progress.html">
                                        <span class="sidebar-menu-text">Progress Bars</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-ui-pagination.html">
                                        <span class="sidebar-menu-text">Pagination</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-button sidebar-js-collapse" data-toggle="collapse"
                                href="#plugins_menu">
                                <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">folder</i>
                                Plugins
                                <span class="ml-auto sidebar-menu-toggle-icon"></span>
                            </a>
                            <ul class="sidebar-submenu sm-indent collapse" id="plugins_menu">
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-ui-charts.html">
                                        <span class="sidebar-menu-text">Charts</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-ui-drag.html">
                                        <span class="sidebar-menu-text">Drag &amp; Drop</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-ui-calendar.html">
                                        <span class="sidebar-menu-text">Calendar</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-ui-nestable.html">
                                        <span class="sidebar-menu-text">Nestable</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-ui-tree.html">
                                        <span class="sidebar-menu-text">Tree</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-ui-maps-vector.html">
                                        <span class="sidebar-menu-text">Vector Maps</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="fixed-ui-sweet-alert.html">
                                        <span class="sidebar-menu-text">Sweet Alert</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <!-- // END Components Menu -->

                    <div class="sidebar-heading">Layout</div>
                    <ul class="sidebar-menu">
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-button" href="instructor-dashboard.html">
                                <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">dashboard</i> Fluid
                                Layout
                            </a>
                        </li>
                        <li class="sidebar-menu-item active">
                            <a class="sidebar-menu-button" href="fixed-instructor-dashboard.html">
                                <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">dashboard</i> Fixed
                                Layout
                            </a>
                        </li>
                    </ul>
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
