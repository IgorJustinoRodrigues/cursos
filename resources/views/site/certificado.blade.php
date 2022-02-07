@extends('template.site')
@section('title', 'Certificado')

@section('header')
    <style>
        .img_cert {
            max-width: 35% !important;
        }

    </style>
@endsection

@section('footer')

@endsection

@section('conteudo')
    <!-- Page Header section start here -->
    <div class="pageheader-section" style="padding: 55px 0 92px !important">
    </div>

    <!-- blog section start here -->
    <div class="shop-single padding-tb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-12">
                    <article>
                        <div class="review">
                            <div class="review-content description-show">
                                <div class="description">
                                    <h3>Certificado </h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                                        irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                                        pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                                        deserunt mollit anim id est laborum.</p>
                                    <div class="post-item">
                                        <div class="post-thumb" >
                                            <img src="{{ URL::asset('imagem/certificado/fundo-frente.jpg') }}" class="img_cert" alt="shop">
                                            <img src="{{ URL::asset('imagem/certificado/fundo-verso.jpg') }}" class="img_cert" alt="shop">
                                        </div>
                                        <div class="post-content">
                                            <ul class="lab-ul">
                                                <li>
                                                    Donec non est at libero vulputate rutrum. pariatur. Excepteur sint
                                                    occaecat cupidatat non proident, sunt in culpa qui officia
                                                    deserunt mollit anim id est laborum.
                                                </li>
                                                <li>
                                                    Morbi ornare lectus quis justo gravida semper.
                                                </li>
                                                <li>
                                                    Pellentesque aliquet, sem eget laoreet ultrices.
                                                </li>
                                                <li>
                                                    Nulla tellus mi, vulputate adipiscing cursus eu, suscipit id nulla.
                                                </li>
                                                <li>
                                                    Donec a neque libero.
                                                </li>
                                                <li>
                                                    Pellentesque aliquet, sem eget laoreet ultrices.
                                                </li>
                                                <li>
                                                    Morbi ornare lectus quis justo gravida semper..
                                                </li>
                                                <li>
                                                    Morbi ornare lectus quis justo gravida semper..
                                                </li>
                                                <li>
                                                    Morbi ornare lectus quis justo gravida semper..
                                                </li>
                                                <li>
                                                    Morbi ornare lectus quis justo gravida semper..
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    </p>
                                </div>
                            </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
    <!-- blog section ending here -->


@endsection
