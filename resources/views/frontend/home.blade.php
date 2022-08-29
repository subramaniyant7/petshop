@extends('frontend.layout')

@section('content')
    @include('admin.notification')
    <!-- ==== Slider ==== -->
    {{-- <div class="container-fluid p-0">
        <div id="slider" class="overlay-parallax-slider"
            style="width:1200px;height:650px;margin:0 auto;margin-bottom: 0px;">
            <div class="ls-slide overlay2" data-ls="duration:4000; transition2d:7;">
                <img src="{{ URL::asset(FRONTEND . '/img/slider/slide1-parallax.jpg') }}" class="ls-bg"
                    alt="" />
                <img width="1200" height="376" src="{{ URL::asset(FRONTEND . '/img/slider/slide1-element.png') }}"
                    class="ls-l" alt="" style="top:296px; right:0
			 %;"
                    data-ls="offsetxin:10; offsetyin:120; durationin:1100; rotatein:5; transformoriginin:59.3% 80.3% 0; offsetxout:-80; durationout:400; parallax:true; parallaxlevel:-4;">


                <div class="ls-l header-wrapper"
                    data-ls="offsetyin:150; durationin:700; delayin:200; easingin:easeOutQuint; rotatexin:20; scalexin:1.4; offsetyout:600; durationout:400; parallax:true; parallaxlevel:2;">
                    <div class="header-text full-width text-light">
                        <h1>Welcome to <span>Untame</span></h1>
                        <!--the div below is hidden on small screens  -->
                        <div class="hidden-small">
                            <p class="header-p">We offer the best services for your pets, contact us today and book a
                                service</p>

                        </div>

                    </div>

                </div>
            </div>


        </div>

    </div> --}}
    <!-- /container-fluid -->
    <!-- ==== Page Content ==== -->
    <!-- section -->

    <video loop autoplay muted id="videoId"  class="custom_video">
        <source src="{{ URL::asset('frontend/video/file.mp4') }}" type="video/mp4">
    </video>
    <section id="intro-home" class="container-fluid bg-light pattern4-right">
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-lg-9">
                    <h3>Quality & Experience </h3>
                    <p>Maecenas at arcu risus. Donec commodo sodales ex, scelerisque laoreet nibh hendrerit id. In
                        aliquet magna nec lobortis maximus. Etiam rhoncus leo a dolor placerat, nec elementum ipsum
                        convall.</p>
                </div>
                <!-- /col-lg-->
                <div class="col-lg-3 justify-content-center align-self-center">
                    <!-- button -->
                    <a href="#" class="btn btn-secondary" data-aos="zoom-out">Contact us</a>
                </div>
                <!-- /col-lg-->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </section>
    <!-- /section ends -->

    <!-- section -->
    <section id="services-home" class="container">
        <div class="container">
            <!-- section heading -->
            <div class="section-heading text-center">
                {{-- <p class="subtitle">what we offer</p> --}}
                <h2>Who are we</h2>
            </div>
            <!-- /section heading -->
            <div class="row">
                <div class="col-lg-7">

                    <span class="h7 mt-0">U N T A M E is a pet food delivery service. We provide the best nutritionally
                        balanced home
                        cooked fresh meal for your furry friends, delivered at your doorstep all across Chennai. Our mission
                        is to
                        break the barrier between fresh nutrition and packaged nutrition that's forced down on us and our
                        pets in
                        this globally commercialized world. We understand that it's not possible for everyone to take on
                        more things
                        in your already busy lives just so you can provide the best for your furmily. So, please allow us to
                        do that
                        for you and help us in our efforts to <br /> U N T A M E the tamed. </span>

                </div>
                <!-- /col-lg-7-->
                <div class="col-lg-5">
                    <img src="{{ URL::asset(FRONTEND . '/img/Whoarewe.webp') }}" class="img-fluid" alt="" />
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </section>
    <!-- /section ends -->
    <!-- section -->
    <section id="about-home" class="overlay-light">
        <div class="container">
            <!-- section heading -->
            <div class="section-heading text-center" style="margin-bottom: 20px">
                <p class="subtitle">Get to know us</p>
                <h2>How its works</h2>
            </div>
            <!-- /section-heading -->
            <div class="row">
                <!-- Tabs -->
                <div class="col-md-12">
                    <img style="width:100%;" src="{{ URL::asset(FRONTEND . '/img/How_it_works_Edited.webp') }}"
                        alt="How it's works">
                </div>
                <!-- col-md-12 -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container-->
    </section>
    <!-- /section ends -->

    <!-- section -->
    {{-- <section id="gallery-home" class="container-fluid pl-0 pr-0">
        <div class="container">
            <!-- section heading -->
            <div class="section-heading text-center">
                <p class="subtitle">Image tour</p>
                <h2>Gallery</h2>
            </div>
            <!-- /section-heading -->
        </div>
        <!-- owl carousel gallery  -->
        <div class="owl-stage owl-carousel owl-theme top-centered-nav mt-5 magnific-popup">
            <div class="col-md-12 gallery-img hover-opacity">
                <!-- image -->
                <a href="{{ URL::asset(FRONTEND . '/img/gallery/gallery1.jpg') }}" title="your caption here">
                    <img src="{{ URL::asset(FRONTEND . '/img/gallery/gallery1.jpg') }}" class="img-fluid rounded"
                        alt="">
                </a>
            </div>
            <!-- /col-md-12 -->
            <div class="col-md-12 gallery-img hover-opacity">
                <a href="{{ URL::asset(FRONTEND . '/img/gallery/gallery2.jpg') }}" title="your caption here">
                    <img src="{{ URL::asset(FRONTEND . '/img/gallery/gallery2.jpg') }}" class="img-fluid rounded"
                        alt="">
                </a>
            </div>
            <!-- /col-md-12 -->
            <div class="col-md-12 gallery-img hover-opacity">
                <a href="{{ URL::asset(FRONTEND . '/img/gallery/gallery3.jpg') }}" title="your caption here">
                    <img src="{{ URL::asset(FRONTEND . '/img/gallery/gallery3.jpg') }}" class="img-fluid rounded"
                        alt="">
                </a>
            </div>
            <!-- /col-md-12 -->
            <div class="col-md-12 gallery-img hover-opacity">
                <a href="{{ URL::asset(FRONTEND . '/img/gallery/gallery4.jpg') }}" title="your caption here">
                    <img src="{{ URL::asset(FRONTEND . '/img/gallery/gallery4.jpg') }}" class="img-fluid rounded"
                        alt="">
                </a>
            </div>
            <!-- /col-md-12 -->
            <div class="col-md-12 gallery-img hover-opacity">
                <a href="{{ URL::asset(FRONTEND . '/img/gallery/gallery5.jpg') }}" title="your caption here">
                    <img src="{{ URL::asset(FRONTEND . '/img/gallery/gallery5.jpg') }}" class="img-fluid rounded"
                        alt="">
                </a>
            </div>
            <!-- /col-md-12 -->
            <div class="col-md-12 gallery-img hover-opacity">
                <a href="{{ URL::asset(FRONTEND . '/img/gallery/gallery6.jpg') }}" title="your caption here">
                    <img src="{{ URL::asset(FRONTEND . '/img/gallery/gallery6.jpg') }}" class="img-fluid rounded"
                        alt="">
                </a>
            </div>
            <!-- /col-md-12 -->
        </div>
        <!-- /owl-carousel -->
    </section> --}}
    <!-- /section ends -->

    <!-- section-->
    <section id="contact-home" class="container-fluid">
        <!-- section heading -->
        <div class="section-heading text-center">
            <p class="subtitle">Get in touch</p>
            <h2>Contact us</h2>
        </div>
        <!-- /section-heading -->
        <div class="container">
            <div class="row">

                <!-- contact box -->
                <div class="col-lg-5 offset-lg-2 h-100">
                    <div class="contact-form3 bg-secondary" data-aos="flip-right">
                        <div class="contact-image bg-secondary">
                            <!-- envelope icon-->
                            <i class="fas fa-envelope bg-secondary"></i>
                        </div>
                        <h4 class="text-center mt-3 text-light">Send us a message</h4>
                        <!-- Form Starts -->
                        <div id="contact_form">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Name<span class="required">*</span></label>
                                        <input type="text" name="name" class="form-control input-field"
                                            required="">
                                    </div>
                                    <div class="col-md-12">
                                        <label>Email address <span class="required">*</span></label>
                                        <input type="email" name="email" class="form-control input-field"
                                            required="">
                                    </div>
                                    <div class="col-md-12">
                                        <label>Subject</label>
                                        <input type="text" name="subject" class="form-control input-field">
                                    </div>
                                    <div class="col-md-12">
                                        <label>Message<span class="required">*</span></label>
                                        <textarea name="message" id="message" class="textarea-field form-control" rows="3" required=""></textarea>
                                    </div>
                                </div>
                                <!-- button -->
                                <button type="submit" id="submit_btn" value="Submit"
                                    class="btn btn-quaternary btn-block mt-3">Send message</button>
                            </div>
                            <!-- /form-group-->
                            <!-- Contact results -->
                            <div id="contact_results"></div>
                        </div>
                        <!-- /contact-form-->
                    </div>
                </div>
                <!-- /col-lg-->
                <div class="text-center col-lg-5 res-margin">
                    <h3>Get in Touch</h3>
                    <p>In aliquet magna nec lobortis maximus. Etiam rhoncus leo a dolor placerat, nec elementum ipsum
                        convall.</p>
                    <!-- contact icons-->
                    <ul class="list-inline mt-3 list-contact colored-icons font-weight-bold">
                        <li class="list-inline-item"><i class="fa fa-envelope margin-icon"></i><a
                                href="mailto:email@yoursite.com">email@yoursite.com</a></li>
                        <li class="list-inline-item"><i class="fa fa-phone margin-icon"></i>(123) 456-789</li>
                        <li class="list-inline-item"><i class="fa fa-map-marker margin-icon"></i>Pet Street 123 -
                            New York</li>
                    </ul>
                    <!-- /list-->
                    <!--divider-->
                    <hr class="mt-2">
                    <!-- map-->

                </div>

                  <!-- image -->
                  <img src="{{ URL::asset(FRONTEND . '/img/about-img.png') }}"
                  class="img-fluid contact-home-img hidden-medium-small" alt="">
            </div>
            <!-- /row-->
        </div>
        <!-- /container-->
    </section>
    <!-- /section -->

@stop


