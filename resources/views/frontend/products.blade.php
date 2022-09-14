@extends('frontend.layout')

@section('content')
    <style>
        .adopt-image {
            border-bottom: none;
        }

        .category-isotope .nav-link {
            color: #fff !important;
        }
    </style>

    <div class="jumbotron jumbotron-fluid" data-center="background-size: 100%;" data-top-bottom="background-size: 110%;">
        <div class="container">
            <!-- jumbo-heading -->
            <div class="jumbo-heading" data-aos="fade-up">
                <h1>Products</h1>
                <!-- Breadcrumbs -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url(FRONTENDURL) }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Recipes</li>
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
            <div class="col-lg-12 page-with-sidebar" style="display: none;">
                <!-- centered Gallery navigation -->
                <ul class="nav nav-pills category-isotope center-nav mt-5">
                    {{-- <li class="nav-item">
                        <a class="nav-link active" href="#" data-toggle="tab" data-filter="*">All</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link active dogclick" href="#" data-toggle="tab" data-filter=".dogs">Dogs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="tab" data-filter=".cats">Cats</a>
                    </li>
                </ul>
                <!-- /ul -->
                <!-- Gallery -->
                <div id="gallery-isotope" class="row row-eq-height mt-lg-5">
                    <!-- Adopt 1 -->
                    @php
                        $activeProducts = getActiveRecord('products');
                    @endphp
                    @if (count($activeProducts))
                        @foreach ($activeProducts as $product)
                            @if ($product->product_default != 1)
                                <div class="{{ $product->product_for == 1 ? 'dogs' : 'cats isotope-hidden' }} col-lg-6">
                                    <div class="isotope-item">
                                        <div class="adopt-card res-margin row bg-light pattern2">
                                            <div class="col-md-5">
                                                <!-- Image -->
                                                <div class="adopt-image d-flex flex-wrap align-items-center ">
                                                    <a href="adoption-single.html">
                                                        <img src="{{ URL::asset('uploads/products/' . $product->product_image) }}"
                                                            class="img-fluid" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-7 res-margin">
                                                <!-- Name -->
                                                <div class="caption-adoption">
                                                    <h5 class="adoption-header"><a
                                                            href="javascript:void(0)">{{ $product->product_name }}</a>
                                                    </h5>
                                                    <!-- List -->
                                                    <ul class="list-unstyled">
                                                        <li><strong>Price:</strong> Rs.{{ $product->product_price }} / Gram
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <!-- Button -->
                                                <div class="text-center">
                                                    <!-- Adopt info -->
                                                    {{ $product->product_description }}
                                                </div>
                                                <!-- /text-center -->
                                            </div>
                                            <!-- /col-md -->
                                        </div>
                                        <!-- /adopt-card -->
                                    </div>
                                    <!-- /isotope-item-->
                                </div>
                                <!-- /col-lg- -->
                            @endif
                        @endforeach

                    @endif
                </div>

                <div class="col-lg-12" style="margin-top:2em;">

                    <h3>Ingredients</h3>
                    <!-- divider -->
                    <hr class="small-divider left">
                    <div class="accordion mt-5" style="padding-left:0 ">
                        <!-- collapsible accordion 1 -->
                        <div class="card">
                            <div class="card-header">
                                <a class="card-link" data-toggle="collapse" href="#collapseOne">
                                    Proteins v
                                </a>
                            </div>
                            <!-- /card-header -->
                            <div id="collapseOne" class="collapse show" data-parent=".accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <p>As the name suggests, our main sources of protein come in the form of 3
                                                    different animal meats with more to be added soon. Proteins are
                                                    quintessential nutrients required by every cell in the body and are
                                                    aptly called the building blocks of life. Meat also provides iron, zinc
                                                    and B vitamins.</p>
                                            </div>
                                            <div class="col-lg-5">
                                                <img style="height:400px;width:100%"
                                                    src="{{ URL::asset(FRONTEND . '/img/proteins.jpeg') }}" alt=""
                                                    class="rounded img-fluid">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /card -->
                        <!-- collapsible accordion 2 -->
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                                    Organ meats
                                </a>
                            </div>
                            <div id="collapseTwo" class="collapse" data-parent=".accordion">
                                <div class="card-body">

                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <p>Compared to regular cuts of muscle meat, organ meats are more densely
                                                    packed with just about every nutrient, including heavy doses of B
                                                    vitamins such as: B1, B2, B6, folic acid and vitamin B12. Organ meats
                                                    are also loaded with minerals like phosphorus, iron, copper, magnesium,
                                                    and provide the important fat-soluble vitamins A, D, E and K.</p>
                                            </div>
                                            <div class="col-lg-5">
                                                <img style="height:400px;width:100%"
                                                    src="{{ URL::asset(FRONTEND . '/img/organmeat.jpeg') }}" alt=""
                                                    class="rounded img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /card -->
                        <!-- collapsible accordion 3 -->
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
                                    Grains
                                </a>
                            </div>
                            <div id="collapseThree" class="collapse" data-parent=".accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <p>Contrary to popular belief, grains are not bad for pets, it's refined
                                                    carbs that spike blood sugar that's the problem. whole grains that we
                                                    use, not only provides your pets energy but also bring in a myriad of
                                                    other essential nutrients like fiber, selenium, zinc, potassium and
                                                    magnesium.</p>
                                            </div>
                                            <div class="col-lg-5">
                                                <img style="height:400px;width:100%"
                                                    src="{{ URL::asset(FRONTEND . '/img/grains.jpg') }}" alt=""
                                                    class="rounded img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /card -->

                        <!-- collapsible accordion 3 -->
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseFour">
                                    Vegetables
                                </a>
                            </div>
                            <div id="collapseFour" class="collapse" data-parent=".accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <p>It's well known that vegetables are rich in vitamins B, C, E, K and also
                                                    contain minerals like calcium, potassium and magnesium which are needed
                                                    for your pets. We include vegetables in their diets to balance acidic
                                                    foods with more alkaline foods to support digestion and to hydrate your
                                                    pets. Most importantly they contain antioxidants and phytonutrients
                                                    which are not easily available in foods.
                                                    Note: Some vegetables safe for dogs are not safe for cats and we will
                                                    avoid those ingredients in the meals accordingly. Legumes: Legumes are a
                                                    great source of protein, vitamin A, C, K, iron and other essential
                                                    nutrients.</p>
                                            </div>
                                            <div class="col-lg-5">
                                                <img style="height:400px;width:100%"
                                                    src="{{ URL::asset(FRONTEND . '/img/vegetables.jpeg') }}" alt=""
                                                    class="rounded img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /card -->

                        <!-- collapsible accordion 3 -->
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseFive">
                                    Legumes
                                </a>
                            </div>
                            <div id="collapseFive" class="collapse" data-parent=".accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <p>Legumes are not considered safe for cats and will not be a part of your
                                                    kitty's meals.</p>
                                            </div>
                                            <div class="col-lg-5">
                                                <img style="height:400px;width:100%"
                                                    src="{{ URL::asset(FRONTEND . '/img/legumes.jpeg') }}"
                                                    alt="" class="rounded img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /card -->

                        <!-- collapsible accordion 3 -->
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseSix">
                                    Mussels
                                </a>
                            </div>
                            <div id="collapseSix" class="collapse" data-parent=".accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <p>While there's a lot of focus on macro nutrients in our pet's diets, micro
                                                    or trace minerals often get left behind. Yet, they should be a crucial
                                                    part of your pet's diet. Mussels have high levels of these trace
                                                    minerals like selenium, omega-3, manganese, iodine, zinc and copper.</p>
                                            </div>
                                            <div class="col-lg-5">
                                                <img style="height:400px;width:100%"
                                                    src="{{ URL::asset(FRONTEND . '/img/mussels.jpeg') }}"
                                                    alt="" class="rounded img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /card -->

                        <!-- collapsible accordion 3 -->
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseSeven">
                                    Oysters
                                </a>
                            </div>
                            <div id="collapseSeven" class="collapse" data-parent=".accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <p>Similar to mussels, oysters contain high levels of some trace minerals
                                                    that mussels have, especially zinc, copper and iron. But using both we
                                                    cover almost all the trace minerals.</p>
                                            </div>
                                            <div class="col-lg-5">
                                                <img style="height:400px;width:100%"
                                                    src="{{ URL::asset(FRONTEND . '/img/oyster.jpeg') }}"
                                                    alt="" class="rounded img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /card -->

                        <!-- collapsible accordion 3 -->
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseEight">
                                    Egg shells
                                </a>
                            </div>
                            <div id="collapseEight" class="collapse" data-parent=".accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <p>There is no denying how important calcium is for everyday functioning of
                                                    your body and for long term bone and body health. This simple ingredient
                                                    is a natural way to provide that key nutrient to your pets.</p>
                                            </div>
                                            <div class="col-lg-5">
                                                <img style="height:400px;width:100%"
                                                    src="{{ URL::asset(FRONTEND . '/img/eggshell.jpeg') }}"
                                                    alt="" class="rounded img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /card -->

                        <!-- collapsible accordion 3 -->
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseNine">
                                    Coconut Oil
                                </a>
                            </div>
                            <div id="collapseNine" class="collapse" data-parent=".accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <p>From easing tummy troubles and soothing irritated skin to preventing
                                                    infections and reducing allergic reactions, there are a lot of benefits
                                                    to your pets consuming coconut oil. One fascinating reason we use them
                                                    is for their natural MCT (Medium Chain Triglycerides) content which has
                                                    been known for their several health benefits, specifically in improving
                                                    brain function and reducing inflammation.</p>
                                            </div>
                                            <div class="col-lg-5">
                                                <img style="height:400px;width:100%"
                                                    src="{{ URL::asset(FRONTEND . '/img/coconutoil.jpeg') }}"
                                                    alt="" class="rounded img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /card -->

                        <!-- collapsible accordion 3 -->
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseTen">
                                    Fish Oil
                                </a>
                            </div>
                            <div id="collapseTen" class="collapse" data-parent=".accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <p>One of the best things to be added to your pet food, fish oil is full of
                                                    healthy fats that help promote heart health, a silky coat, reduces itchy
                                                    flaky skin and helps with joint pain. Apart from these, fish oil is the
                                                    no.1 source of Omega-3 fatty acids which help balance the Omega-6 in the
                                                    diet. Over availability of Omega-6 in the body can cause inflammation
                                                    and fish oil helps keep them in check.</p>
                                            </div>
                                            <div class="col-lg-5">
                                                <img style="height:400px;width:100%"
                                                    src="{{ URL::asset(FRONTEND . '/img/fish-oil.jpeg') }}"
                                                    alt="" class="rounded img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /card -->

                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseElevan">
                                    Flax and Chia
                                </a>
                            </div>
                            <div id="collapseElevan" class="collapse" data-parent=".accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <p>Chia is said to be an immune-system booster and is credited with
                                                    supporting dogs electrolyte balance. Flax is high in fiber, and both are
                                                    high in anti-inflammatories.</p>
                                            </div>
                                            <div class="col-lg-5">
                                                <img style="height:400px;width:100%"
                                                    src="{{ URL::asset(FRONTEND . '/img/flax-and-chia.jpeg') }}"
                                                    alt="" class="rounded img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwelve">
                                    Seaweed
                                </a>
                            </div>
                            <div id="collapseTwelve" class="collapse" data-parent=".accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <p>Iodine is one of those important nutrients that gets overlooked and ends
                                                    up being deficient in diets. While salt is a definite NO for your pets,
                                                    seaweed is surprisingly low in sodium and high in iodine making it the
                                                    perfect add-on to their meals.</p>
                                            </div>
                                            <div class="col-lg-5">
                                                <img style="height:400px;width:100%"
                                                    src="{{ URL::asset(FRONTEND . '/img/seaweed.jpeg') }}"
                                                    alt="" class="rounded img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseThirteen">
                                    Turmeric
                                </a>
                            </div>
                            <div id="collapseThirteen" class="collapse" data-parent=".accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <p>This yellow spice has been taking over the world by storm and it's no
                                                    different when it comes to your pet. It's been known to help with so
                                                    many ailments like joint pain, prevent or help treat cancer, boosts
                                                    immunity, helps with autoimmune diseases and more.</p>
                                            </div>
                                            <div class="col-lg-5">
                                                <img style="height:400px;width:100%"
                                                    src="{{ URL::asset(FRONTEND . '/img/turmeric.jpeg') }}"
                                                    alt="" class="rounded img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseFourteen">
                                    Cilantro
                                </a>
                            </div>
                            <div id="collapseFourteen" class="collapse" data-parent=".accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <p>Cilantro is a natural detoxifier that helps shuttle heavy metals out of
                                                    the body. Studies have also shown that vegetables belonging to the
                                                    apiaceous family like cilantro are known to help reduce carcinogenic
                                                    effects from mold.</p>
                                            </div>
                                            <div class="col-lg-5">
                                                <img style="height:400px;width:100%"
                                                    src="{{ URL::asset(FRONTEND . '/img/cilantro.jpeg') }}"
                                                    alt="" class="rounded img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /accordion -->

                    <!-- /col-lg-7 -->






                    {{-- <h2>Ingredients</h2>
                    <hr class="small-divider left">
                    <p class="mt-4">
                        <strong>Proteins:</strong> As the name suggests, our main sources of protein come in the form of 3
                        different
                        animal meats with more to be added soon. Proteins are quintessential nutrients required by
                        every cell in the body and are aptly called the building blocks of life. Meat also provides iron,
                        zinc and B vitamins.
                        <br /><br />
                        <strong>Organ meats:</strong> Compared to regular cuts of muscle meat, organ meats are more densely
                        packed with just about every nutrient, including heavy doses of B vitamins such as: B1, B2,
                        B6, folic acid and vitamin B12. Organ meats are also loaded with minerals like phosphorus,
                        iron, copper, magnesium, and provide the important fat-soluble vitamins A, D, E and K.
                        <br /><br />
                        <strong>Grains:</strong> Contrary to popular belief, grains are not bad for pets, it's refined carbs
                        that spike
                        blood sugar that's the problem. whole grains that we use, not only provides your pets energy
                        but also bring in a myriad of other essential nutrients like fiber, selenium, zinc, potassium
                        and magnesium.
                        <br /><br />
                        <strong>Vegetables:</strong> It's well known that vegetables are rich in vitamins B, C, E, K and
                        also contain
                        minerals like calcium, potassium and magnesium which are needed for your pets. We
                        include vegetables in their diets to balance acidic foods with more alkaline foods to support
                        digestion and to hydrate your pets. Most importantly they contain antioxidants and
                        phytonutrients which are not easily available in foods.
                        <br />
                        <strong>Note:</strong> Some vegetables safe for dogs are not safe for cats and we will avoid those
                        ingredients in the meals accordingly.
                        Legumes: Legumes are a great source of protein, vitamin A, C, K, iron and other essential
                        nutrients.
                        <br /> <br />
                        <strong>Legumes:</strong> Legumes are not considered safe for cats and will not be a part of your
                        kitty's meals.
                        <br /> <br />
                        <strong>Mussels:</strong> While there's a lot of focus on macro nutrients in our pet's diets, micro
                        or trace
                        minerals often get left behind. Yet, they should be a crucial part of your pet's diet. Mussels
                        have high levels of these trace minerals like selenium, omega-3, manganese, iodine, zinc
                        and copper.
                        <br /><br />
                        <strong>Oysters:</strong> Similar to mussels, oysters contain high levels of some trace minerals
                        that mussels
                        have, especially zinc, copper and iron. But using both we cover almost all the trace minerals.
                        <br /><br />
                        <strong>Egg shells:</strong> There is no denying how important calcium is for everyday functioning
                        of your
                        body and for long term bone and body health. This simple ingredient is a natural way to
                        provide that key nutrient to your pets.
                        <br /> <br />
                        <strong>Coconut Oil:</strong> From easing tummy troubles and soothing irritated skin to preventing
                        infections
                        and reducing allergic reactions, there are a lot of benefits to your pets consuming coconut
                        oil. One fascinating reason we use them is for their natural MCT (Medium Chain
                        Triglycerides) content which has been known for their several health benefits, specifically in
                        improving brain function and reducing inflammation.
                        <br /><br />
                        <strong>Fish Oil:</strong> One of the best things to be added to your pet food, fish oil is full of
                        healthy fats that
                        help promote heart health, a silky coat, reduces itchy flaky skin and helps with joint pain.
                        Apart from these, fish oil is the no.1 source of Omega-3 fatty acids which help balance the
                        Omega-6 in the diet. Over availability of Omega-6 in the body can cause inflammation and
                        fish oil helps keep them in check.
                        <br /><br />
                        <strong>Flax and Chia:</strong> Chia is said to be an immune-system booster and is credited with
                        supporting
                        dogs electrolyte balance. Flax is high in fiber, and both are high in anti-inflammatories.
                        <br /> <br />
                        <strong>Seaweed:</strong> Iodine is one of those important nutrients that gets overlooked and ends
                        up being
                        deficient in diets. While salt is a definite NO for your pets, seaweed is surprisingly low in
                        sodium and high in iodine making it the perfect add-on to their meals.
                        <br /><br />
                        <strong>Turmeric:</strong>This yellow spice has been taking over the world by storm and it's no
                        different
                        when it comes to your pet. It's been known to help with so many ailments like joint pain,
                        prevent or help treat cancer, boosts immunity, helps with autoimmune diseases and more.
                        <br /><br />
                        <strong>Cilantro:</strong> Cilantro is a natural detoxifier that helps shuttle heavy metals out of
                        the body.
                        Studies have also shown that vegetables belonging to the apiaceous family like cilantro are
                        known to help reduce carcinogenic effects from mold.
                    </p> --}}
                </div>
            </div>
        </div>
    </div>

@stop

@section('footer')
    <script>
        setTimeout(() => {
            $('.page-with-sidebar').fadeIn();
            $(".dogclick").trigger("click");
        }, 100);
    </script>

@stop
