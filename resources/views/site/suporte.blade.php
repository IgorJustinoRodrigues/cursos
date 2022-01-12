@extends('template.site')
@section('title', 'Suporte')

@section('header')

@endsection

@section('footer')

@endsection

@section('conteudo')
    <!-- Page Header section start here -->
    <div class="pageheader-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="pageheader-content text-center">
                        <h2>Entre em contato conosco</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="index.html">Início</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Entre em contato conosco</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header section ending here -->

    <!-- Map & address us Section Section Starts Here -->
    <div class="map-address-section padding-tb section-bg">
        <div class="container">
            <div class="section-header text-center">
                <span class="subtitle">ENTRE EM CONTATO CONOSCO</span>
                <h2 class="title">Estamos sempre ansiosos para ouvir de você!</h2>
            </div>
            <div class="section-wrapper">
                <div class="row flex-row-reverse">
                    <div class="col-xl-4 col-lg-5 col-12">
                        <div class="contact-wrapper">
                            <div class="contact-item">
                                <div class="contact-thumb">
                                    <img src="{{ URL::asset('site/images/icon/01.png') }}" alt="CodexCoder">
                                </div>
                                <div class="contact-content">
                                    <h6 class="title">Office Address</h6>
                                    <p>1201 park street, Fifth Avenue</p>
                                </div>
                            </div>
                            <div class="contact-item">
                                <div class="contact-thumb">
                                    <img src="{{ URL::asset('site/images/icon/02.png') }}" alt="CodexCoder">
                                </div>
                                <div class="contact-content">
                                    <h6 class="title">Phone number</h6>
                                    <p>+22698 745 632,02 982 745</p>
                                </div>
                            </div>
                            <div class="contact-item">
                                <div class="contact-thumb">
                                    <img src="{{ URL::asset('site/images/icon/03.png') }}" alt="CodexCoder">
                                </div>
                                <div class="contact-content">
                                    <h6 class="title">Send email </h6>
                                    <a href="mailto:info@gmail.com">adminedukon@gmil.com</a>
                                </div>
                            </div>
                            <div class="contact-item">
                                <div class="contact-thumb">
                                    <img src="{{ URL::asset('site/images/icon/04.png') }}" alt="CodexCoder">
                                </div>
                                <div class="contact-content">
                                    <h6 class="title">Our website</h6>
                                    <a href="#">www.adminedukon@gmil.com</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-7 col-12">
                        <form class="contact-form" action="contact.php" id="contact-form" method="POST">
                            <div class="form-group">
                                <input type="text" placeholder="Your Name" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Your Email" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Phone" id="phone" name="phone" required>
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Subject" id="subject" name="subject" required>
                            </div>
                            <div class="form-group w-100">
                                <textarea name="message" rows="4" id="message" placeholder="Your Message"
                                    required></textarea>
                            </div>
                            <div class="form-group w-100 text-center">
                                <button class="lab-btn"><span>Send our Message</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Map & address us Section Section Ends Here -->


@endsection
