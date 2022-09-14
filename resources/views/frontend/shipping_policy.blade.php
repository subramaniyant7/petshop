@extends('frontend.layout')

@section('content')

    <div class="jumbotron jumbotron-fluid" data-center="background-size: 100%;" data-top-bottom="background-size: 110%;" style="background: rgb(50, 50, 50) !important;padding:0">
        <div class="container">
            <!-- jumbo-heading -->
            <div class="jumbo-heading" data-aos="fade-up">
                <h1>Shipping Policy</h1>
                <!-- Breadcrumbs -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url(FRONTENDURL) }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shipping Policy</li>
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
                    <h2>Shipping Policy</h2>
                    <hr class="small-divider left">
                    <p class="mt-4">
                        <strong>Delivery and Handling</strong> <br /><br />
                        Deliveries will be twice a week unless otherwise stated during your purchase.
                        Untame Pets may, in sole and absolute discretion, without giving any prior notice, revise such changes.
                        <br /><br />
                        Delivery times and dates are only estimates.
                        <br /><br />
                        Once the order is placed and confirmed, any changes made to the order or delivery will only take effect if
                        it's made before 24 hours of the next scheduled delivery, failing which the changes will go into effect only
                        after the upcoming delivery is complete.
                        <br /><br />

                        <strong>Pricing and Taxes</strong> <br /><br />
                        Delivery and handling fees are included with your order, unless otherwise indicated at the time of your purchase.
                        <br /><br />
                        The price of the product on the website is exclusive of GST which will be added at checkout, unless otherwise stated.<br /><br />

                        The final amount paid includes the products, delivery and GST.<br /><br />


                    </p>
                </div>
            </div>
        </div>
    </div>

@stop
