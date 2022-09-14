<style>
    .nav-link {
        color: #539B3C !important;
    }
</style>
<nav id="main-nav" class="navbar-expand-xl fixed-top">
    <div>
        <!-- Start Top Bar -->
        {{-- <div class="container-fluid top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Start Contact Info -->
                        <ul class="contact-details float-left">
                            <li><i class="fa fa-map-marker"></i>Chennai</li>
                            <li><i class="fa fa-envelope"></i><a href="mailto:email@site.com">woof@untame.pet</a>
                            </li>
                            <li><i class="fa fa-phone"></i>+91 9150529991</li>
                        </ul>
                        <!-- End Contact Info -->
                        <!-- Start Social Links -->
                        <ul class="social-list float-right list-inline">
                            <li class="list-inline-item">
                                <a title="Facebook" href="https://www.facebook.com/untamepets/" target="_blank">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a title="Twitter" href="https://twitter.com/UntamePets" target="_blank">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a title="Instagram" href="https://www.instagram.com/untamepets/" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a target="_blank" title="Whatsapp"
                                    href="https://api.whatsapp.com/send/?phone=919150529991&text=Hi+there%21+How+can+we+help+you+today%3F&type=phone_number&app_absent=0">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- /End Social Links -->
                    </div>
                    <!-- col-md-12 -->
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div> --}}
        <!-- End Top bar -->
        <!-- Navbar Starts -->
        <div class="navbar container-fluid" >
            <div class="container ">
                <!-- logo -->
                <a class="nav-brand" href="{{ url(FRONTENDURL) }}">
                    <img src="{{ URL::asset(FRONTEND . '/img/Final_Logo_UntamePets_01.webp') }}" alt=""
                        class="img-fluid">
                </a>
                <!-- Navbartoggler -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggle-icon">
                        <i class="fas fa-bars"></i>
                    </span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <!-- menu item -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url(FRONTENDURL) }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url(FRONTENDURL . 'about_us') }}">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url(FRONTENDURL . 'products') }}">Recipes</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url(FRONTENDURL . 'faq') }}">FAQs</a>
                        </li>
                        @if (session('frontenduserid'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url(FRONTENDURL . 'dashboard') }}">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url(FRONTENDURL . 'register') }}">Register</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url(FRONTENDURL . 'login') }}">Login</a>
                            </li>
                        @endif

                    </ul>
                    <!--/ul -->
                </div>
                <!--collapse -->
            </div>
            <!-- /container -->
        </div>
        <!-- /navbar -->
    </div>
    <!--/row -->
</nav>
<!-- /nav -->
