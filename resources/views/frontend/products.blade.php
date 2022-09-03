@extends('frontend.layout')

@section('content')

    <div class="jumbotron jumbotron-fluid" data-center="background-size: 100%;" data-top-bottom="background-size: 110%;">
        <div class="container">
            <!-- jumbo-heading -->
            <div class="jumbo-heading" data-aos="fade-up">
                <h1>Products</h1>
                <!-- Breadcrumbs -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url(FRONTENDURL) }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Products</li>
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
            <div class="col-lg-9 page-with-sidebar">
                <div class="col-lg-12">
                    <h2>Ingredients</h2>
                    <hr class="small-divider left">
                    <p class="mt-4">
                        <strong>Proteins:</strong> As the name suggests, our main sources of protein come in the form of 3 different
                        animal meats with more to be added soon. Proteins are quintessential nutrients required by
                        every cell in the body and are aptly called the building blocks of life. Meat also provides iron,
                        zinc and B vitamins.
                        <br/><br/>
                        <strong>Organ meats:</strong> Compared to regular cuts of muscle meat, organ meats are more densely
                        packed with just about every nutrient, including heavy doses of B vitamins such as: B1, B2,
                        B6, folic acid and vitamin B12. Organ meats are also loaded with minerals like phosphorus,
                        iron, copper, magnesium, and provide the important fat-soluble vitamins A, D, E and K.
                        Grains: Contrary to popular belief, grains are not bad for pets, it’s refined carbs that spike
                        blood sugar that’s the problem. whole grains that we use, not only provides your pets energy
                        but also bring in a myriad of other essential nutrients like fiber, selenium, zinc, potassium
                        and magnesium.
                        <br/><br/>
                        <strong>Vegetables:</strong> It’s well known that vegetables are rich in vitamins B, C, E, K and also contain
                        minerals like calcium, potassium and magnesium which are needed for your pets. We
                        include vegetables in their diets to balance acidic foods with more alkaline foods to support
                        digestion and to hydrate your pets. Most importantly they contain antioxidants and
                        phytonutrients which are not easily available in foods.
                        <br/><br/>
                        <strong>Note:</strong> Some vegetables safe for dogs are not safe for cats and we will avoid those
                        ingredients in the meals accordingly.
                        Legumes: Legumes are a great source of protein, vitamin A, C, K, iron and other essential
                        nutrients.
                        <br/>
                        <strong>Note:</strong> Legumes are not considered safe for cats and will not be a part of your kitty’s meals.
                        Mussels: While there’s a lot of focus on macro nutrients in our pet’s diets, micro or trace
                        minerals often get left behind. Yet, they should be a crucial part of your pet’s diet. Mussels
                        have high levels of these trace minerals like selenium, omega-3, manganese, iodine, zinc
                        and copper.
                        <br/><br/>
                        <strong>Oysters:</strong> Similar to mussels, oysters contain high levels of some trace minerals that mussels
                        have, especially zinc, copper and iron. But using both we cover almost all the trace minerals.
                        <br/><br/>
                        <strong>Egg shells:</strong> There is no denying how important calcium is for everyday functioning of your
                        body and for long term bone and body health. This simple ingredient is a natural way to
                        provide that key nutrient to your pets.
                        Coconut Oil: From easing tummy troubles and soothing irritated skin to preventing infections
                        and reducing allergic reactions, there are a lot of benefits to your pets consuming coconut
                        oil. One fascinating reason we use them is for their natural MCT (Medium Chain
                        Triglycerides) content which has been known for their several health benefits, specifically in
                        improving brain function and reducing inflammation.
                        <br/><br/>
                        <strong>Fish Oil:</strong> One of the best things to be added to your pet food, fish oil is full of healthy fats that
                        help promote heart health, a silky coat, reduces itchy flaky skin and helps with joint pain.
                        Apart from these, fish oil is the no.1 source of Omega-3 fatty acids which help balance the
                        Omega-6 in the diet. Over availability of Omega-6 in the body can cause inflammation and
                        fish oil helps keep them in check.
                        <br/><br/>
                        <strong>Flax and Chia:</strong> Chia is said to be an immune-system booster and is credited with supporting
                        dogs’ electrolyte balance. Flax is high in fiber, and both are high in anti-inflammatories.
                        Seaweed: Iodine is one of those important nutrients that gets overlooked and ends up being
                        deficient in diets. While salt is a definite NO for your pets, seaweed is surprisingly low in
                        sodium and high in iodine making it the perfect add-on to their meals. 
                        <br/><br/>
                        <strong>Turmeric:</strong>This yellow spice has been taking over the world by storm and it’s no different
                        when it comes to your pet. It’s been known to help with so many ailments like joint pain,
                        prevent or help treat cancer, boosts immunity, helps with autoimmune diseases and more.
                        <br/><br/>
                        <strong>Cilantro:</strong> Cilantro is a natural detoxifier that helps shuttle heavy metals out of the body.
                        Studies have also shown that vegetables belonging to the apiaceous family like cilantro are
                        known to help reduce carcinogenic effects from mold.
                    </p>
                </div>
            </div>
        </div>
    </div>

@stop