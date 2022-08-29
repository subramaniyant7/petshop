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
            <div class="col-lg-9 page-with-sidebar">
                <div class="col-lg-12">
                    <h2>About us</h2>
                    <hr class="small-divider left">
                    <p class="mt-4">
                       Coming Soon
                    </p>
                </div>
            </div>
        </div>
    </div>

@stop
