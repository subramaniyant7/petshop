<style>
    .list-unstyled li{
        font-weight: bold;
        color: #044B16;
    }
</style>
<footer class="bg-light pattern1">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 text-center ">
                <a href="{{ url(FRONTENDURL) }}"><img src="{{ URL::asset(FRONTEND . '/img/Final_Logo_UntamePets_01.webp') }}" class="logo-footer img-fluid"
                    alt="" /></a>
                <!-- Start Social Links -->
                {{-- <ul class="social-list text-center list-inline">
                    <li class="list-inline-item"><a title="Facebook" href="#"><i class="fab fa-facebook-f"></i></a>
                    </li>
                    <li class="list-inline-item"><a title="Twitter" href="#"><i class="fab fa-twitter"></i></a>
                    </li>
                    <li class="list-inline-item"><a title="Instagram" href="#"><i
                                class="fab fa-instagram"></i></a></li>
                </ul> --}}
                <!-- /End Social Links -->
            </div>
            <!--/ col-lg -->
            <div class="col-lg-3">
                <h5>About us</h5>
                <!--divider -->
                <hr class="small-divider left" />
                <p class="mt-3">U N T A M E is a pet food delivery service. We provide the best nutritionally balanced
                    home cooked fresh meal for your furry friends, delivered at your doorstep all across Chennai.</p>
            </div>
            <!--/ col-lg -->
            <div class="col-lg-3">
                <h5>Contact Us</h5>
                <!--divider -->
                <hr class="small-divider left" />
                <ul class="list-unstyled mt-3">
                    <li class="mb-1"><i class="fas fa-phone margin-icon "></i>+91 9150529991</li>
                    <li class="mb-1"><i class="fas fa-envelope margin-icon"></i><a
                            href="mailto:woof@untame.pet">woof@untame.pet</a></li>
                    <li><i class="fas fa-map-marker margin-icon"></i>Chennai </li>
                    <li>
                        <ul class="social-list text-left list-inline" style="margin-left:-0.5em;">
                            <li class="list-inline-item"><a title="Facebook" href="https://www.facebook.com/untamepets/" target="_blank"><i
                                        class="fab fa-facebook-f"></i></a></li>
                            <li class="list-inline-item"><a title="Twitter" href="https://twitter.com/UntamePets" target="_blank"><i
                                        class="fab fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a title="Instagram" href="https://www.instagram.com/untamepets/" target="_blank"><i
                                        class="fab fa-instagram"></i></a></li>
                        </ul>
                    </li>
                </ul>
                <!--/ul -->
            </div>
            <!--/ col-lg -->
            <div class="col-lg-3">
                <h5>Links</h5>
                <!--divider -->
                <hr class="small-divider left" />
                <ul class="list-unstyled mt-3">
                    <li class="mb-1"><a href="{{ url(FRONTENDURL . 'about_us') }}">About Us</a></li>
                    <li class="mb-1"><a href="{{ url(FRONTENDURL . 'terms_conditions') }}">Terms and Conditions</a></li>
                    <li class="mb-1"><a href="{{ url(FRONTENDURL . 'disclaimer') }}">Disclaimer</a></li>
                    <li class="mb-1"><a href="{{ url(FRONTENDURL . 'privacy_policy') }}">Privacy Policy</a></li>
                    <li class="mb-1"><a href="{{ url(FRONTENDURL . 'return_refund') }}">Return and Refund</a></li>
                    <li class="mb-1"><a href="{{ url(FRONTENDURL . 'shipping_policy') }}">Shipping Policy</a></li>

                </ul>
                <!--/ul -->
            </div>
            <!--/ col-lg -->
        </div>
        <!--/ row-->
        <hr />
        <div class="row">
            <div class="credits col-sm-12">
                <p>Copyright {{ date('Y')}} By UNTAME PETS. All Rights Reserved.</p>
                {{-- <p>Copyright {{ date('Y') }} / Developed by <a href="https://www.niftysoft.com/"
                        target="_blank">NiftySoft Solution Pvt Ltd</a></p> --}}
            </div>
        </div>
        <!--/col-lg-12-->
    </div>
    <!--/ container -->
    <!-- Go To Top Link -->
    <div class="page-scroll hidden-sm hidden-xs">
        <a href="#top" class="back-to-top"><i class="fa fa-angle-up"></i></a>
    </div>
    <!--/page-scroll-->
</footer>
<!--/ footer-->
