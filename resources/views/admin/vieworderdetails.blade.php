@extends('admin.layouts')

@section('title', 'View Order Details')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Order Details</h6>
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-primary btn-rounded" href="{{ url(ADMINURL . '/vieworder') }}">
                                <i class="fa fa-arrow"> </i> Back
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap mt-40">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-12 mb-10 text-left">Order Id :
                                                    {{ $orders[0]->order_inc_id }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-12 mb-10 text-left">User Email :
                                                    <span>{{ getUser($orders[0]->user_id)[0]->user_email }}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-12 mb-10 text-left">Order Type :
                                                    <span>{{ $orders[0]->order_type == 1 ? 'Partial' : 'Complete' }}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-12 mb-10 text-left">Total Quantity :
                                                    <span>{{ $orders[0]->totalGram / 1000 }} KG</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-12 mb-10 text-left">Total Price :
                                                    <span>Rs.{{ number_format($orders[0]->grandTotal, 2) }}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-12 mb-10 text-left">Delivery Date :
                                                    <span>{{ $orders[0]->delivery_date }}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-12 mb-10 text-left">Payment Id :
                                                    <span>{{ $orders[0]->paymentId }}</span></label>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        @php
                                            $address = getAddress($orders[0]->user_id);
                                        @endphp
                                         <h3>Shipping Address</h3>
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
                                            @endif
                                        </address>
                                    </div>

                                    <div class="col-md-12">

                                        <div class="col-md-12">
                                            <h3>Product Details</h3>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Image</th>
                                                        <th>Product</th>
                                                        <th>Price</th>
                                                        <th>Quantity(KG)</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orderProducts as $k => $data)
                                                        @php
                                                            $product = getProducts($data->product_id);
                                                            $image = count($product) ? $product[0]->product_image : '';
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $k + 1 }}</td>
                                                            <td><img style="min-height: 100px;max-height:100px;"
                                                                    src="{{ URL::asset('uploads/products/' . $image) }}">
                                                            </td>
                                                            <td>{{ $data->product_name }}</td>
                                                            <td>Rs.{{ $data->product_price }}/Gram</td>
                                                            <td>{{ $data->product_qty / 1000 }}</td>
                                                            <td>Rs.{{ number_format($data->product_price * $data->product_qty, 2) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="4"></td>
                                                        <td>Sub Total</td>
                                                        <td> Rs.{{ number_format($orders[0]->totalPrice, 2) }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="4"></td>
                                                        <td>GST</td>
                                                        <td> Rs.{{ number_format($orders[0]->gst, 2) }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="4"></td>
                                                        <td>Grand Total</td>
                                                        <td> Rs.{{ number_format($orders[0]->grandTotal, 2) }}</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@stop
