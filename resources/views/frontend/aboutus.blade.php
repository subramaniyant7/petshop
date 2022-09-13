@extends('frontend.layout')

@section('content')

    <div class="jumbotron jumbotron-fluid" data-center="background-size: 100%;" data-top-bottom="background-size: 110%;">
        <div class="container">
            <!-- jumbo-heading -->
            <div class="jumbo-heading" data-aos="fade-up">
                <h1>About Us</h1>
                <!-- Breadcrumbs -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url(FRONTENDURL) }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">About Us</li>
                    </ol>
                </nav>
                <!-- /breadcrumb -->
            </div>
            <!-- /jumbo-heading -->
        </div>
        <!-- /container -->
    </div>

    <div class="page container" style="padding-top:50px;">
        <div class="row">
            <!-- page with sidebar starts -->
            <div class="col-lg-12 page-with-sidebar">
                <div class="col-lg-12">
                    <h2>About us</h2>
                    <hr class="small-divider left">
                    <p class="mt-4">
                        When we decided to move back home to Chennai, we had no idea we’d have so much trouble trying to
                        find a suitable food source for our fur baby.
                        We visited so many stores and found quite many options, but it didn't take much time for us to
                        realize that it was just the same thing
                        under different names - Super processed brown pellets in a bag or something in a can with claims so
                        tall that it made our head spin.
                        It didn’t take us long to make up our minds that it was better to continue to do what we always did,
                        make the food for our boy ourselves.
                        Very soon we realized that we’re probably not the only ones who ran into this situation.
                        <br /><br />
                        We at Untame Pets - a pet food delivery service, provide the best nutritionally balanced home cooked
                        fresh meal for your furry friends,
                        delivered at your doorstep all across Chennai. Our mission is to break the barrier between fresh
                        nutrition and packaged nutrition that's
                        forced down on us and our pets in this globally commercialized world. We understand that though one
                        would love to, it's not possible for
                        everyone to take on more things in today’s already busy lives just to provide the best for your
                        furmily. And that’s why we are here, please
                        allow us to do that for you and help us in our efforts to U N T A M E the tamed.
                        <br /><br />
                    </p>
                    <p>
                    <h3><strong>Our Vision</strong></h3>
                    <strong>Species Appropriate Nutrition</strong><br />
                    Animals can eat any food and barely survive, but to truly thrive, they must eat a diet that its species
                    has evolved to
                    eat - a diet that its body is able to consume and digest. That is the goal of Untame Pets, not just to
                    provide sustenance,
                    but a species appropriate nutrition.<br /><br />

                    <strong>Transparency</strong><br />
                    You will not find any proprietary blends or secret ingredients in our products. If you're considering
                    feeding our
                    food to your pets, we believe you have every right to know what goes in it and how much it
                    costs.<br /><br />

                    <strong>One world, one home!</strong><br />
                    It is no secret that we share this world with countless organisms. We want to do our best to preserve
                    this world for not just our future generations but for all living things that need it. We strive to be
                    environmentally friendly in every way we can and are always on the lookout for newer and better ways to
                    achieve it.<br /><br />
                    </p>
                </div>
            </div>
        </div>
    </div>

@stop
