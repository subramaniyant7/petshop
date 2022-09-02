@extends('frontend.layout')

@section('content')
    <div class="page container">
        <div class="row">

            <div class="col-lg-12 page-with-sidebar">
                <div class="row">
                    <div class="col-lg-12" style="display:flex;justify-content: space-between;margin-bottom: 2em;">
                        <h2>Order Products Details</h2>
                        <a href="{{FRONTENDURL.'myorders'}}" class="btn btn-primary">Back</a>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getOrderProducts as $k => $data)
                                @php
                                    $product = getProducts($data->product_id);
                                    $image = count($product) ? $product[0]->product_image : '';
                                @endphp
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td><img style="min-height: 100px;max-height:100px;"
                                                src="{{ URL::asset('uploads/products/' . $image) }}"></td>
                                        <td>{{ $data->product_name }}</td>
                                        <td>Rs.{{ $data->product_price }}/Gram</td>
                                        <td>{{ $data->product_qty }}</td>
                                        <td>Rs.{{ number_format($data->product_price * $data->product_qty,2) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4"></td>
                                    <td >Total</td>
                                    <td> Rs.{{ number_format($getOrder[0]->totalPrice,2) }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
