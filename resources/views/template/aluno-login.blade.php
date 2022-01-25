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

<body class="login">
    @yield('conteudo')


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
