@extends('frontend.layout')

@section('content')

    <div class="jumbotron jumbotron-fluid" data-center="background-size: 100%;" data-top-bottom="background-size: 110%;" style="background: rgb(50, 50, 50) !important;padding:0">
        <div class="container">
            <!-- jumbo-heading -->
            <div class="jumbo-heading" data-aos="fade-up">
                <h1>FAQs</h1>
                <!-- Breadcrumbs -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url(FRONTENDURL) }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">FAQ</li>
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
                <div class="container-fluid block-padding pb-block ">
                    <div class="container">
                        <div class="row pattern4-right">
                            <div class="col-lg-5 d-flex flex-wrap align-items-center">
                                <!-- image -->
                                <img src="{{ URL::asset(FRONTEND . '/img/servicesimg2.png') }}" class="img-fluid "
                                    alt="">
                            </div>
                            <!-- /col-lg-5 -->
                            <div class="col-lg-7">
                                <h3>Frequently asked questions</h3>
                                <!-- divider -->
                                <hr class="small-divider left">
                                <div class="accordion mt-5">
                                    <!-- collapsible accordion 1 -->
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="card-link" data-toggle="collapse" href="#collapseOne">
                                                Does my pet really need variety in their food?
                                            </a>
                                        </div>
                                        <!-- /card-header -->
                                        <div id="collapseOne" class="collapse show" data-parent=".accordion">
                                            <div class="card-body">
                                                <p>When it comes to texture, aroma and variety, our pets are so much like we
                                                    humans are. We get tired of eating the same thing all the time,
                                                    especially if it’s bland and boring. The need to have some variety in
                                                    our diets is what drives us to try new foods and recipes. And for the
                                                    same reason your pet will walk away from food they once loved but are
                                                    tired of eating. Changing it up sometimes and mixing up the proteins
                                                    will give your pet a renewed excitement about their food. Also,
                                                    different animal proteins provide different nutrients in varying
                                                    amounts. Feeding a variety of foods will help cover all the bases when
                                                    it comes to nutrition.</p>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /card -->
                                    <!-- collapsible accordion 2 -->
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                                                Why should I feed my dog fresh food from Untame Pets?
                                            </a>
                                        </div>
                                        <div id="collapseTwo" class="collapse" data-parent=".accordion">
                                            <div class="card-body">
                                                <p>Dogs evolved by our side over thousands of years, changing themselves to
                                                    our needs and still cannot eat everything we can. How do we expect them
                                                    to consume and adapt to this newly formulated, highly processed dry
                                                    pellets we call dog food? We, at Untame Pets aim to take a step back and
                                                    produce fresh meals that your dog evolved to eat and not only meet their
                                                    nutritional requirements or reduce their vet visits, but bring back more
                                                    excitement to your beloved pooch at mealtime.</p>
                                                <p>Also, if the zero additives we use to keep our food fresh and the real
                                                    ingredients that you can see in your dog’s bowl, as opposed to the
                                                    mysterious brown balls of kibble does not impress you, then the science
                                                    backed claims of everything from better breath to longer lifespan
                                                    should!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /card -->
                                    <!-- collapsible accordion 3 -->
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
                                                Why should I feed my cat fresh food from Untame Pets?
                                            </a>
                                        </div>
                                        <div id="collapseThree" class="collapse" data-parent=".accordion">
                                            <div class="card-body">
                                                <p>Answer for the above question is applicable here as well + Cats are only
                                                    semi- domesticated and are still obligate carnivores, meaning they can
                                                    derive most of the nutrition they need from meat. We make sure at least
                                                    90% of the nutrients for your cat is from Proteins and fats. This helps
                                                    reduce the incidence of feline diabetes and obesity due to high blood
                                                    sugar levels which is a growing problem. Also, cats evolved primarily
                                                    from being desert animals which explains their low thirst drive. Luckily
                                                    our meals are not highly processed and dry, so they contain a lot more
                                                    moisture, keeping your kitty hydrated which also helps reduce the risk
                                                    of kidney stones and renal issues.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /card -->


                                    <!-- collapsible accordion 3 -->
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#collapseFour">
                                                Why is there no vegetarian option for my cat?
                                            </a>
                                        </div>
                                        <div id="collapseFour" class="collapse" data-parent=".accordion">
                                            <div class="card-body">
                                                <p>Cats being obligate carnivores, have deficient amounts of digestive
                                                    enzymes necessary to process plant material into an efficient usable
                                                    energy source or biologically active form. Cats have a fairly simple
                                                    digestive tract and lack the ability to synthesize certain amino acids
                                                    from their diet. There are four amino acids (taurine, arginine,
                                                    methionine and cysteine) that must be provided in their diet and are
                                                    best found in animal proteins, not plant proteins. In addition, given
                                                    their relatively short gastrointestinal tract, they have a dramatically
                                                    reduced ability to extract nutrients from plant material. The biological
                                                    value of animal protein is almost twice that of a plant protein for
                                                    cats.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /card -->


                                    <!-- collapsible accordion 3 -->
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#collapseFive">
                                                How does delivery work?
                                            </a>
                                        </div>
                                        <div id="collapseFive" class="collapse" data-parent=".accordion">
                                            <div class="card-body">
                                                <p>Delivery will be twice a week (Tuesdays and Fridays) in the mornings. Our
                                                    meals will arrive in single day portioned packages with resealable
                                                    zippers, that way you can feed your pet multiple times a day if you wish
                                                    and still keep the product fresh and refrigerated without it drying out.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /card -->



                                    <!-- collapsible accordion 3 -->
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#collapseSix">
                                                Do I have to convert my pet to fresh food completely?
                                            </a>
                                        </div>
                                        <div id="collapseSix" class="collapse" data-parent=".accordion">
                                            <div class="card-body">
                                                <p>While feeding fresh food has to be one of the best ways to provide your
                                                    pet with healthy nutrition, we understand it might not be feasible for
                                                    everyone for a multitude of reasons. That's exactly why we have a
                                                    partial option on your order. If you choose to, you can get a partial
                                                    order of any of our meals and replace the other half with your pet's old
                                                    food. Research suggests that any amount of fresh food given to your pet
                                                    is way more beneficial to them than not giving any at all.</p>
                                                <p>If you do opt for a partial order, please be aware that this is only 50%
                                                    of your pet’s daily sustenance and will not suffice their hunger or
                                                    daily food requirement. It is important the remainder of the meal be
                                                    supplemented with their old food or something appropriate.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /card -->


                                    <!-- collapsible accordion 3 -->
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#collapseSeven">
                                                How do I change my pet from their current diet to fresh food from Untame
                                                Pets?
                                            </a>
                                        </div>
                                        <div id="collapseSeven" class="collapse" data-parent=".accordion">
                                            <div class="card-body">
                                                <p>Any pet which is not used to a variety of foods will take a little time
                                                    to adjust to a change in diet. That's why for a new pet, we
                                                    automatically add a starter pack based on your pet's information which
                                                    will contain food for the first 5 days to aid with the transition.
                                                    Replace your pet's old food with 10% of fresh food from Untame Pets on
                                                    day-1, on day-2 replace 25%, 50% on day-3, 75% on day-4 and 100% on
                                                    day-5! This will help your pet get slowly accustomed to the new diet.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /card -->


                                    <!-- collapsible accordion 3 -->
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#collapseEight">
                                                How does the food stay fresh for days?
                                            </a>
                                        </div>
                                        <div id="collapseEight" class="collapse" data-parent=".accordion">
                                            <div class="card-body">
                                                <p>We take the utmost care and follow proper hygiene protocols when it comes
                                                    to preparing and packaging your pet's meal. Packaged meals are heat
                                                    sealed and refrigerated to retain freshness and shelf life. Our current
                                                    recommended shelf life for all our products is 5 days from date of
                                                    manufacture.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /card -->


                                    <!-- collapsible accordion 3 -->
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#collapseNine">
                                                A lot of people cook at home, what's special about your recipes?
                                            </a>
                                        </div>
                                        <div id="collapseNine" class="collapse" data-parent=".accordion">
                                            <div class="card-body">
                                                <p>It's great for people who cook for their pets at home! But, not so great
                                                    for people who do not have the time, energy or the knowledge to produce
                                                    balanced meals that will meet all the nutritional requirements of your
                                                    pet. That's where we come in! While we completely endorse and encourage
                                                    people taking the time to cook for their pets, we do not recommend
                                                    feeding unbalanced meals or human food scraps as they tend to contain
                                                    ingredients which are not always pet friendly and sometimes hazardous.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /card -->


                                    <!-- collapsible accordion 3 -->
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#collapseTen">
                                                What are the changes I can see in my pet?
                                            </a>
                                        </div>
                                        <div id="collapseTen" class="collapse" data-parent=".accordion">
                                            <div class="card-body">
                                                <p>Initially during the adjustment phase, you might notice some loose
                                                    stools, which will stop once the transition period is complete. In fact,
                                                    you might start noticing that your pet's poops are smaller and a lot
                                                    less stinky, especially if you are switching from highly processed dry
                                                    food. It might also cross your mind that your pet is now less flatulent
                                                    which makes sharing any closed space with your pet more enjoyable. Pet's
                                                    coats might tend to get softer and shinier as they get all the healthy
                                                    fats they need. Most skin related allergy/itching issues might go away
                                                    as they consume a more species appropriate diet with less inflammatory
                                                    ingredients. These are just a few things you can notice right away on
                                                    the outside. There is a lot more going on the inside, providing your pet
                                                    with all the nutrition they require helps them maintain and run their
                                                    systems more efficiently which might help them keep good health and
                                                    maybe even live longer!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /card -->


                                </div>
                                <!-- /accordion -->
                            </div>
                            <!-- /col-lg-7 -->
                        </div>
                        <!-- /row -->
                    </div>
                    <!-- /container -->
                </div>
            </div>
        </div>
    </div>

@stop
