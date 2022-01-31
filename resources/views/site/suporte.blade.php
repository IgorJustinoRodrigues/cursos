@extends('template.site')
@section('title', 'Suporte')

@section('header')
    <style>
        .titulo {
            color: #ffffff;
        }

    </style>
@endsection

@section('footer')

@endsection

@section('conteudo')
    <!-- Page Header section start here -->
    <div class="pageheader-section" style="padding: 55px 0 92px !important">
    </div>
    <!-- Page Header section ending here -->

    <!-- Map & address us Section Section Starts Here -->
    <div class="map-address-section padding-tb section-bg">
        <div class="container">
            <div class="section-wrapper">
                <aside>
                    <div class="widget shop-widget">
                        <div class="widget-header">
                            <h5>Dúvidas Frequentes</h5>
                        </div>
                        <div class="widget-wrapper">
                            <ul class="shop-menu lab-ul">
                                <li>
                                    <a href="#0">Code Optimization</a>
                                    <ul class="shop-submenu lab-ul">
                                        <li><a href="#0">Seo</a></li>
                                        <li><a href="#0">Marketing</a></li>
                                        <li><a href="#0">Email Marketing</a></li>
                                        <li><a href="#0">Seo Support</a></li>
                                    </ul>
                                </li>
                                <li><a href="#0">Monitoring Ranking</a>
                                    <ul class="shop-submenu lab-ul">
                                        <li><a href="#0">All Products</a></li>
                                        <li><a href="#0">Seo</a></li>
                                        <li><a href="#0">Marketing</a></li>
                                        <li><a href="#0">Email Marketing</a></li>
                                        <li><a href="#0">Seo Support</a></li>
                                    </ul>
                                </li>
                                <li><a href="#0">Target Strategy</a>
                                    <ul class="shop-submenu lab-ul">
                                        <li><a href="#0">All Products</a></li>
                                        <li><a href="#0">Seo</a></li>
                                        <li><a href="#0">Marketing</a></li>
                                        <li><a href="#0">Email Marketing</a></li>
                                        <li><a href="#0">Seo Support</a></li>
                                    </ul>
                                </li>
                                <li><a href="#0">Nap Syndication</a>
                                    <ul class="shop-submenu lab-ul">
                                        <li><a href="#0">All Products</a></li>
                                        <li><a href="#0">Seo</a></li>
                                        <li><a href="#0">Marketing</a></li>
                                        <li><a href="#0">Email Marketing</a></li>
                                        <li><a href="#0">Seo Support</a></li>
                                    </ul>
                                </li>
                                <li><a href="#0">SEO Support</a>
                                    <ul class="shop-submenu lab-ul">
                                        <li><a href="#0">All Products</a></li>
                                        <li><a href="#0">Seo</a></li>
                                        <li><a href="#0">Marketing</a></li>
                                        <li><a href="#0">Email Marketing</a></li>
                                        <li><a href="#0">Seo Support</a></li>
                                    </ul>
                                </li>
                                <li><a href="#0">Email Marketing</a>
                                    <ul class="shop-submenu lab-ul">
                                        <li><a href="#0">All Products</a></li>
                                        <li><a href="#0">Seo</a></li>
                                        <li><a href="#0">Marketing</a></li>
                                        <li><a href="#0">Email Marketing</a></li>
                                        <li><a href="#0">Seo Support</a></li>
                                    </ul>
                                </li>
                                <li><a href="#0">Engine Marketing</a>
                                    <ul class="shop-submenu lab-ul">
                                        <li><a href="#0">All Products</a></li>
                                        <li><a href="#0">Seo</a></li>
                                        <li><a href="#0">Marketing</a></li>
                                        <li><a href="#0">Email Marketing</a></li>
                                        <li><a href="#0">Seo Support</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </aside>
                <hr>
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
                        <div class="section-wrapper">
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
                                    <textarea name="message" rows="8" id="message" placeholder="Your Message"
                                        required></textarea>
                                </div>
                                <div class="form-group w-100 text-center">
                                    <button class="lab-btn"><span>Send our Message</span></button>
                                </div>
                            </form>
                            <p class="form-message"></p>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>

    <!-- Map & address us Section Section Ends Here -->




@endsection
