@extends('frontend.layout')

@section('content')
    <div class="page container">
        <div class="row">
            @include('frontend.sidebar')

            <div class="col-lg-9 page-with-sidebar">
                <div class="row">
                    @include('admin.notification')
                    <div class="col-lg-12">
                        <h2>Shipping Address </h2>
                    </div>
                    <!-- /col-lg-->

                    <div class="col-lg-12 col-md-12">
                        <p class="mt-3 res-margin">
                        <address>
                            @if (count($address))
                                {{ $address[0]->first_name }} {{ $address[0]->last_name }},<br>
                                {{ $address[0]->address1 }},<br>
                                @if ($address[0]->address2 != '')
                                    {{ $address[0]->address2 }},<br>
                                @endif
                                {{ userCity()[$address[0]->city-1] }},
                                {{ userState()[$address[0]->state-1]  }},
                                {{ userCountry()[$address[0]->country-1] }},<br>
                                @if ($address[0]->landmark != '')
                                    {{ $address[0]->landmark }},<br>
                                @endif
                                {{ $address[0]->zipcode }}.<br><br>

                                <a href="{{url(FRONTENDURL.'editshippingaddress/'.encryption($address[0]->user_address_id))}}" class="btn btn-primary mt-4">Edit Shipping Address</a>
                            @else
                                <a href="{{url(FRONTENDURL.'addshippingaddress')}}" class="btn btn-primary mt-4">Add Shipping Address</a>
                            @endif
                        </address>
                        </p>
                    </div>
                </div>
                <!-- /row-->

            </div>
            <!-- /page-with-sidebar -->



        </div>
        <!-- /row -->
    </div>

@stop
