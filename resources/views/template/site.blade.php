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
                            <i class="icofont-location-pin"></i> Beverley, New York 224 USA
                        </li>
                    </ul>
                    <ul class="lab-ul social-icons d-flex align-items-center">
                        <li><p>Find us on : </p></li>
                        <li><a href="#" class="fb"><i class="icofont-facebook-messenger"></i></a></li>
                        <li><a href="#" class="twitter"><i class="icofont-twitter"></i></a></li>
                        <li><a href="#" class="vimeo"><i class="icofont-vimeo"></i></a></li>
                        <li><a href="#" class="skype"><i class="icofont-skype"></i></a></li>
                        <li><a href="#" class="rss"><i class="icofont-rss-feed"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container">
                <div class="header-wrapper">
                    <div class="logo">
                        <a href="index.html"><img src="{{ URL::asset('site/images/logo/01.png') }}" alt="logo"></a>
                    </div>
                    <div class="menu-area">
                        <div class="menu">
                            <ul class="lab-ul">
                                <li>
                                    <a href="#0">Home</a>
                                    <ul class="lab-ul">
                                        <li><a href="index.html">Home One</a></li>
                                        <li><a href="index-2.html">Home Two</a></li>
                                        <li><a href="index-3.html">Home Three</a></li>
                                        <li><a href="index-4.html">Home Four</a></li>
                                        <li><a href="index-5.html">Home Five</a></li>
                                        <li><a href="index-6.html">Home Six</a></li>
                                        <li><a href="index-7.html">Home Seven</a></li>
                                    </ul>
                                </li>
                                
                                <li>
                                    <a href="#0">Courses</a>
                                    <ul class="lab-ul">
                                        <li><a href="course.html">Course</a></li>
                                        <li><a href="course-single.html">Course Details</a></li>
    
                                    </ul>
                                </li>
                                <li>
                                    <a href="#0">Blog</a>
                                    <ul class="lab-ul">
                                        <li><a href="blog.html">Blog Grid</a></li>
                                        <li><a href="blog-2.html">Blog Style 2</a></li>
                                        <li><a href="blog-3.html">Blog Style 3</a></li>
                                        <li><a href="blog-single.html">Blog Single</a></li>
                                    </ul>
                                </li>
                                <li class="active">
                                    <a href="#0">Pages</a>
                                    <ul class="lab-ul">
                                        <li><a href="about.html">About</a></li>
                                        <li><a href="team.html">Team</a></li>
                                        <li><a href="instructor.html">Instructor</a></li>
                                        <li>
                                            <a href="#0">Shop Pages</a>
                                            <ul class="lab-ul">
                                                <li><a href="shop.html">Shop Page</a></li>
                                                <li><a href="shop-single.html">Shop Details Page</a></li>
                                                <li><a href="cart-page.html">Shop Cart Page</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="search-page.html">Search Page</a></li>
                                        <li><a href="search-none.html">Search None</a></li>
                                        <li><a href="404.html">404</a></li>
                                    </ul>
                                </li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </div>
                        
                        <a href="{{ route('acessoAluno') }}" class="login"><i class="icofont-user"></i> <span>ACESSO DE ALUNO</span> </a>

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
                        <h3>Want Us To Email You About Special Offers And Updates?</h3>
                    </div>
                    <div class="news-form">
                        <form action="/">
                            <div class="nf-list">
                                <input type="email" name="email" placeholder="Enter Your Email">
                                <input type="submit" name="submit" value="Subscribe Now">
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
                                            <h4>Site Map</h4>
                                        </div>
                                        <div class="content">
                                            <ul class="lab-ul">
                                                <li><a href="#">Documentation</a></li>
                                                <li><a href="#">Feedback</a></li>
                                                <li><a href="#">Plugins</a></li>
                                                <li><a href="#">Support Forums</a></li>
                                                <li><a href="#">Themes</a></li>
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
                                            <h4>Useful Links</h4>
                                        </div>
                                        <div class="content">
                                            <ul class="lab-ul">
                                                <li><a href="#">About Us</a></li>
                                                <li><a href="#">Help Link</a></li>
                                                <li><a href="#">Terms & Conditions</a></li>
                                                <li><a href="#">Contact Us</a></li>
                                                <li><a href="#">Privacy Policy</a></li>
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
                                            <h4>Social Contact</h4>
                                        </div>
                                        <div class="content">
                                            <ul class="lab-ul">
                                                <li><a href="#">Facebook</a></li>
                                                <li><a href="#">Twitter</a></li>
                                                <li><a href="#">Instagram</a></li>
                                                <li><a href="#">YouTube</a></li>
                                                <li><a href="#">Github</a></li>
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
                                            <h4>Our Support</h4>
                                        </div>
                                        <div class="content">
                                            <ul class="lab-ul">
                                                <li><a href="#">Help Center</a></li>
                                                <li><a href="#">Paid with Mollie</a></li>
                                                <li><a href="#">Status</a></li>
                                                <li><a href="#">Changelog</a></li>
                                                <li><a href="#">Contact Support</a></li>
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
                        <p>&copy; 2021 <a href="index.html">Edukon</a> Designed by <a href="https://themeforest.net/user/CodexCoder" target="_blank">CodexCoder</a> </p>
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