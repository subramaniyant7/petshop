<!DOCTYPE html>
<html lang="en">

@include('frontend.head')

<!-- ==== body starts ==== -->

<body id="top">

    @include('frontend.loader')
    @include('frontend.navbar')

    @yield('content')

    @include('frontend.footer')

    <!-- Bootstrap core & Jquery -->
    <script src="{{ URL::asset(FRONTEND . '/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset(FRONTEND . '/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- Custom Js -->
    <script src="{{ URL::asset(FRONTEND . '/js/custom.js') }}"></script>
    <script src="{{ URL::asset(FRONTEND . '/js/plugins.js') }}"></script>
    <!-- Prefix free -->
    <script src="{{ URL::asset(FRONTEND . '/js/prefixfree.min.js') }}"></script>
    <!-- Bootstrap Select Tool (For Module #4) -->
    <script src="{{ URL::asset(FRONTEND . '/switcher/js/bootstrap-select.js') }}"></script>
    <!-- All Scripts & Plugins -->
    <script src="{{ URL::asset(FRONTEND . '/switcher/js/dmss.js') }}"></script>

    <!-- End Google Tag Manager (noscript) -->


    <!-- number counter script -->
    <script src="{{ URL::asset(FRONTEND . '/js/counter.js') }}"></script>
    <!-- maps -->
    {{-- <script src="{{ URL::asset(FRONTEND . '/js/map.js') }}"></script> --}}
    <!-- GreenSock -->
    <script src="{{ URL::asset(FRONTEND . '/vendor/layerslider/js/greensock.js') }}"></script>
    <!-- LayerSlider script files -->
    <script src="{{ URL::asset(FRONTEND . '/vendor/layerslider/js/layerslider.transitions.js') }}"></script>
    <script src="{{ URL::asset(FRONTEND . '/vendor/layerslider/js/layerslider.kreaturamedia.jquery.js') }}"></script>
    <script src="{{ URL::asset(FRONTEND . '/vendor/layerslider/js/layerslider.load.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script src="{{ URL::asset(FRONTEND . '/js/own.js') }}"></script>

</body>

</html>
