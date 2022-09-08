@extends('frontend.layout')

@section('content')

    <div class="jumbotron jumbotron-fluid" data-center="background-size: 100%;" data-top-bottom="background-size: 110%;">
        <div class="container">
            <!-- jumbo-heading -->
            <div class="jumbo-heading" data-aos="fade-up">
                <h1>Return and Refund</h1>
                <!-- Breadcrumbs -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url(FRONTENDURL) }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Return and Refund</li>
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
                    <h2>Return and Refund</h2>
                    <hr class="small-divider left">
                    <p class="mt-4">
                        <strong>Return of Goods and Conditions</strong> <br /><br />
                        We at Untame Pets take stringent measures when it comes to food safety and handling because our products are perishable.
                        This makes us unable to accept returns or exchanges.
                        <br /><br />
                        If your reason for considering a return is simply that your pet does not prefer our meals and the freshness of the food
                        has not been compromised or contaminated, please consider not throwing them away and leaving the food out for strays.
                        <br /><br />


                        <strong>Refunds policy</strong> <br /><br />
                        You are entitled to cancel your order within 14 days of first delivery without giving any reason for doing so.
                        <br /><br />
                        Post 14 days of the first delivery the amount corresponding to the remaining services for the month will not be refunded.<br /><br />

                        Amounts for orders that are already serviced will not be refunded.<br /><br />

                        GST will not be refunded for cancellation requests after the 7th of the following month.<br /><br />

                        In order to exercise your right of cancellation, you must inform us of your decision by means of a clear statement.<br /><br />

                        You can inform us of your decision by an e-mail to woof@untame.pet<br /><br />

                        We will reimburse you no later than 30 days from the day on which we receive the request provided all the above conditions
                        are met. We will use the same means of payment as you used for the order.<br /><br />

                        <strong>Pause and Cancellations</strong> <br /><br />
                        If for any reason you want to pause or cancel your order, you can do so online through your account on the site or by contacting us.
                         Please refer to the above policy for refunds.
                        <br /><br />

                        Orders cannot be paused for longer than 60 days<br /><br />

                        Any pause or cancellation of order has to be communicated before 48 hours of the next scheduled delivery,
                        failing which the changes will go into effect only after the upcoming delivery is completed. <br /><br />

                        <strong>Contact Us</strong> <br /><br />
                        If you have any questions about our Returns and Refunds Policy, please contact us by e-mail : <strong>woof@untame.pet</strong>
                        <br /><br />
                    </p>
                </div>
            </div>
        </div>
    </div>

@stop
