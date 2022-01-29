@extends('template.site')
@section('title', 'Professor')

@section('header')

@endsection

@section('footer')

@endsection

@section('conteudo')
    <!--Tela de Professor-->

    <!-- Page Header section start here -->
    <div class="pageheader-section" style="padding: 55px 0 92px !important">

    </div>
    <!-- Page Header section ending here -->

    <!-- instructor Single Section Starts Here -->
    <section class="instructor-single-section padding-tb section-bg">
        <div class="container">
            <div class="instructor-wrapper">
                <div class="instructor-single-top">
                    <div class="instructor-single-item d-flex flex-wrap justify-content-between">
                        <div class="instructor-single-thumb">
                            <img src="{{ URL::asset('site/images/instructor/single/01.jpg') }}" alt="instructor">
                        </div>
                        <div class="instructor-single-content">
                            <h4 class="title">Emilee Logan</h4>
                            <p class="ins-dege">Master of Education Degree</p>
                            <span class="ratting">
                                <i class="icofont-ui-rating"></i>
                                <i class="icofont-ui-rating"></i>
                                <i class="icofont-ui-rating"></i>
                                <i class="icofont-ui-rating"></i>
                                <i class="icofont-ui-rating"></i>
                            </span>
                            <p class="ins-desc">Infrastruct ntrinsicl grow optimal talers rather than efectve nformaon
                                Collabora optimize partnersh and frictionles deliverables</p>
                            <h6 class="subtitle">Personal Statement</h6>
                            <p class="ins-desc">Enthusa expedte clent focused growth strateg wherea clent centered
                                infrastruct ntrinsicl grow optimal talers rather than efectve nformaon Collabora optimize
                                partnersh and frictionles deliverables infrastructs ntrinsicl grow optimal talers rather
                                efectve</p>
                            <ul class="lab-ul">
                                <li class="d-flex flex-wrap justify-content-start">
                                    <span class="list-name">Adress</span>
                                    <span class="list-attr">Suite 02 and 07 Melbourne, Australia</span>
                                </li>
                                <li class="d-flex flex-wrap justify-content-start">
                                    <span class="list-name">Email</span>
                                    <span class="list-attr">emileelogan@gamil.com</span>
                                </li>
                                <li class="d-flex flex-wrap justify-content-start">
                                    <span class="list-name">Phone</span>
                                    <span class="list-attr">+021 548 736 982 ,01236985</span>
                                </li>
                                <li class="d-flex flex-wrap justify-content-start">
                                    <span class="list-name">website</span>
                                    <span class="list-attr">www.adminEdukon.com</span>
                                </li>
                                <li class="d-flex flex-wrap justify-content-start">
                                    <span class="list-name">Follow Us</span>
                                    <ul class="lab-ul list-attr d-flex flex-wrap justify-content-start">
                                        <li>
                                            <a class="twitter" href="#"><i class="icofont-twitter"></i></a>
                                        </li>
                                        <li>
                                            <a class="instagram" href="#"><i class="icofont-instagram"></i></a>
                                        </li>
                                        <li>
                                            <a class="basketball" href="#"><i class="icofont-basketball"></i></a>
                                        </li>
                                        <li>
                                            <a class="vimeo" href="#"><i class="icofont-vimeo"></i></a>
                                        </li>
                                        <li>
                                            <a class="beahnce" href="#"><i class="icofont-behance"></i></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="instructor-single-bottom d-flex flex-wrap mt-4">
                    <div class="col-xl-6 pb-5 pb-xl-0 d-flex flex-wrap justify-content-lg-start justify-content-between">
                        <h4 class="subtitle">Personal Language Skill</h4>
                        <div class="text-center skill-item">
                            <div class="skill-thumb">
                                <div class="circles text-center">
                                    <div class="circle first" data-percent="80">
                                        <strong>80<i>%</i></strong>
                                    </div>
                                </div>
                            </div>
                            <p>English</p>
                        </div>
                        <div class="text-center skill-item">
                            <div class="skill-thumb">
                                <div class="circles text-center">
                                    <div class="circle second" data-percent="70">
                                        <strong>70<i>%</i></strong>
                                    </div>
                                </div>
                            </div>
                            <p>Hindi</p>
                        </div>
                        <div class="text-center skill-item">
                            <div class="skill-thumb">
                                <div class="circles text-center">
                                    <div class="circle third" data-percent="60">
                                        <strong>60<i>%</i></strong>
                                    </div>
                                </div>
                            </div>
                            <p>Bangla</p>
                        </div>
                    </div>
                    <div class="col-xl-6 d-flex flex-wrap justify-content-lg-start justify-content-between">
                        <h4 class="subtitle">Recognitions Award</h4>
                        <div class="skill-item text-center">
                            <div class="skill-thumb">
                                <img src="assets/images/instructor/single/icon/01.png" alt="instructor">
                            </div>
                            <p>Award 2018</p>
                        </div>
                        <div class="skill-item text-center">
                            <div class="skill-thumb">
                                <img src="assets/images/instructor/single/icon/02.png" alt="instructor">
                            </div>
                            <p>Award 2019</p>
                        </div>
                        <div class="skill-item text-center">
                            <div class="skill-thumb">
                                <img src="assets/images/instructor/single/icon/03.png" alt="instructor">
                            </div>
                            <p>Award 2020</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- instructor Single Section Ends Here -->
@endsection
