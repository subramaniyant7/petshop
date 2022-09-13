@extends('frontend.layout')

@section('content')
    @include('admin.notification')

    <video loop autoplay muted id="videoId" class="custom_video" width="100%">
        <source src="{{ URL::asset('frontend/video/file.mp4') }}" type="video/mp4">
    </video>


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



    <section id="feature-section" class="bg-light pattern1" style="background-color:rgb(50, 50, 50) !important">
        <div class="container">
            <!-- section heading -->
            <div class="section-heading text-center">
                <h2 style="color:#fff">Why Us</h2>
            </div>
            <!-- /section-heading -->
            <!-- features -->
            <div class="row text-lg-center">
                <div class="col-md-6 col-lg-4">
                    <!-- feature -->
                    <div class="feature-with-icon">
                        <div class="icon-features">
                            <!-- icon -->

                            <img src="{{ URL::asset(FRONTEND . '/img/flowers.webp') }}">
                        </div>
                        <h5 style="color:#fff"><strong>FRESH</strong></h5>
                        <p style="color:#fff">Our meals are neither frozen nor dry but made fresh on a daily basis with lots of love, scoops of
                            nutrition and mounds of utmost care.</p>
                    </div>
                    <!-- /feature-with-icon-->
                </div>

                <div class="col-md-6 col-lg-4">
                    <!-- feature -->
                    <div class="feature-with-icon">
                        <div class="icon-features">
                            <!-- icon -->
                            <img src="{{ URL::asset(FRONTEND . '/img/healthy.webp') }}">
                        </div>
                        <h5 style="color:#fff"><strong>HEALTHY</strong></h5>
                        <p style="color:#fff">Prepared using preservative free ingredients, everything used in your pet's meal is recognizable
                            and not something out of a chemistry class. This also makes our meals hypoallergenic! </p>
                    </div>
                    <!-- /feature-with-icon-->
                </div>

                <div class="col-md-6 col-lg-4">
                    <!-- feature -->
                    <div class="feature-with-icon">
                        <div class="icon-features">
                            <!-- icon -->
                            <img src="{{ URL::asset(FRONTEND . '/img/food.webp') }}">
                        </div>
                        <h5 style="color:#fff"><strong>DELICIOUS</strong></h5>
                        <p style="color:#fff">Why feed your pooch the same, old and boring? Our meals are guaranteed to stimulate not just
                            their appetite but their senses too with enticing aroma and interesting textures!</p>
                    </div>
                    <!-- /feature-with-icon-->
                </div>

                <div class="col-md-6 col-lg-4">
                    <!-- feature -->
                    <div class="feature-with-icon">
                        <div class="icon-features">
                            <!-- icon -->
                            <img src="{{ URL::asset(FRONTEND . '/img/diet.webp') }}">
                        </div>
                        <h5 style="color:#fff"><strong>HUMAN GRADE</strong></h5>
                        <p style="color:#fff">Our food is made from 100% human grade fresh fruits, vegetables and meat. We do not use store or
                            farm waste. We believe our pets deserve high quality nutrition just like we do.</p>
                    </div>
                    <!-- /feature-with-icon-->
                </div>



                <div class="col-md-6 col-lg-4">
                    <!-- feature -->
                    <div class="feature-with-icon">
                        <div class="icon-features">
                            <!-- icon -->
                            <img src="{{ URL::asset(FRONTEND . '/img/store.webp') }}">
                        </div>
                        <h5 style="color:#fff"><strong>LOCAL</strong></h5>
                        <p style="color:#fff">We only use fresh regionally-sourced ingredients from the local markets/farms ensuring best
                            quality, while also supporting the local businesses.</p>
                    </div>
                    <!-- /feature-with-icon-->
                </div>

                <div class="col-md-6 col-lg-4">
                    <!-- feature -->
                    <div class="feature-with-icon">
                        <div class="icon-features">
                            <!-- icon -->
                            <img src="{{ URL::asset(FRONTEND . '/img/customs.webp') }}">
                        </div>
                        <h5 style="color:#fff"><strong>CUSTOMIZABLE</strong></h5>
                        <p style="color:#fff">Got a kitty with an existing health condition? or a puppy that's still growing? Their nutritional
                            needs are different and we can cater to them by customizing our meals to their needs.</p>
                    </div>
                    <!-- /feature-with-icon-->
                </div>

                <div class="col-md-6 col-lg-4">
                    <!-- feature -->
                    <div class="feature-with-icon">
                        <div class="icon-features">
                            <!-- icon -->
                            <img src="{{ URL::asset(FRONTEND . '/img/save-money.webp') }}">
                        </div>
                        <h5 style="color:#fff"><strong>AFFORDABLE</strong></h5>
                        <p style="color:#fff">We strongly believe providing for your pet shouldn't cost you a paw and a claw. We guarantee our
                            prices will be affordable at premium quality.</p>
                    </div>
                    <!-- /feature-with-icon-->
                </div>

                <div class="col-md-6 col-lg-4">
                    <!-- feature -->
                    <div class="feature-with-icon">
                        <div class="icon-features">
                            <!-- icon -->
                            <img src="{{ URL::asset(FRONTEND . '/img/environmental.webp') }}">
                        </div>
                        <h5 style="color:#fff"><strong>ECOFRIENDLY</strong></h5>
                        <p style="color:#fff">All our packaging is bio-degradable! And by sourcing everything locally we help reduce emissions
                            and energy use. Want to help reduce your emissions? Go local! Choose us!</p>
                    </div>
                    <!-- /feature-with-icon-->
                </div>


            </div>
            <!-- /row-->
        </div>
        <!-- /container -->
    </section>


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
    <section id="contact-home" class="container-fluid" style="background-color:rgb(50, 50, 50) !important">
        <!-- section heading -->
        <div class="section-heading text-center">
            <p class="subtitle" style="color:#fff">Get in touch</p>
            <h2 style="color:#fff">Contact us</h2>
        </div>
        <!-- /section-heading -->
        <div class="container">
            <div class="row">
                @include('admin.notification')
                <!-- contact box -->
                <div class="col-lg-5 offset-lg-1 h-100">
                    <div class="contact-form3 bg-secondary" data-aos="flip-right">
                        <div class="contact-image bg-secondary">
                            <!-- envelope icon-->
                            <i class="fas fa-envelope bg-secondary"></i>
                        </div>
                        <h4 class="text-center mt-3 text-light" >Send us a message</h4>
                        <!-- Form Starts -->
                        <div id="contact_form">
                            <form method="POST" action="{{ url(FRONTENDURL.'contactus')}}">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Name<span class="required">*</span></label>
                                            <input type="text" name="name" class="form-control input-field" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Email address <span class="required">*</span></label>
                                            <input type="email" name="email" class="form-control input-field" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Subject</label>
                                            <input type="text" name="subject" class="form-control input-field" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Message<span class="required">*</span></label>
                                            <textarea name="content" id="content" class="textarea-field form-control" rows="3" required=""></textarea>
                                        </div>
                                    </div>
                                    <!-- button -->
                                    <button type="submit"  value="Submit"
                                        class="btn btn-quaternary btn-block mt-3">Send message</button>
                                </div>
                            </form>
                            <!-- /form-group-->
                            <!-- Contact results -->
                            <div id="contact_results"></div>
                        </div>
                        <!-- /contact-form-->
                    </div>
                </div>
                <!-- /col-lg-->
                <div class="text-center col-lg-5 res-margin">
                    <h3 style="color:#fff">Get in Touch</h3>

                    <!-- contact icons-->
                    <ul class="list-inline mt-3 list-contact colored-icons font-weight-bold">
                        <li class="list-inline-item" style="color:#fff"><i class="fa fa-envelope margin-icon"></i><a
                                href="mailto:woof@untame.pet" style="color:#fff">woof@untame.pet</a></li>
                        <li class="list-inline-item" style="color:#fff"><i class="fa fa-phone margin-icon"></i>+91 9150529991</li>
                        <li class="list-inline-item" style="color:#fff"><i class="fa fa-map-marker margin-icon"></i>Chennai</li>
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
