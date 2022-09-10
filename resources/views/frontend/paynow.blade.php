@extends('frontend.layout')


@section('content')
    <div class="page container">
        <div class="row">
            <div class="col-lg-9 page-with-sidebar">
                <div class="row">

                    <div class="col-lg-12 col-md-12">
                        <div id="contact_form">
                            <div class="row">
                                <div class="col-md-12">

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Product</th>
                                                <th>Price(Gram)</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orderProductInfo as $k => $data)
                                                <tr>
                                                    <td>{{ $k + 1 }}</td>
                                                    <td>{{ $data->product_name }}</td>
                                                    <td>Rs.{{ $data->product_price }}</td>
                                                    <td>{{ $data->product_qty }}</td>
                                                    <td>{{ number_format($data->product_price * $data->product_qty,2) }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="3"></td>
                                                <td >Total</td>
                                                <td> Rs.{{ number_format($orderInfo[0]->totalPrice,2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <input type="hidden" id="total" value="{{ $orderInfo[0]->totalPrice }}">
                                    <input type="hidden" id="order_id" value="{{ encryption($orderInfo[0]->order_id) }}">
                                    <button type="button" style="float:right" value="Pay Now" id="rzp-button1" class="btn btn-primary">Pay
                                        Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
