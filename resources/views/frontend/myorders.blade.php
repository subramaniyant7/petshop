@extends('frontend.layout')

@section('content')
    <div class="page container">
        <div class="row">
            @include('frontend.sidebar')

            <div class="col-lg-9 page-with-sidebar">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>My Orders </h2>
                    </div>
                    <!-- /col-lg-->
                    @include('admin.notification')
                    <div class="col-lg-12 col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Order ID</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Payment Status</th>
                                    <th>Delivery Date</th>
                                    <th>View Products</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($getOrders as $k => $orders)
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ $orders->order_inc_id }}</td>
                                        <td>{{ $orders->totalGram }} Gram</td>
                                        <td>Rs.{{ number_format($orders->totalPrice, 2) }}</td>
                                        <td>{{ $orders->paymentId != '' ? 'Paid' : 'In-Progress' }}</td>
                                        <td>{{ $orders->delivery_date }}</td>
                                        <td><a href="{{ FRONTENDURL.'myorderproducts/'.encryption($orders->order_id)}}">View</a></td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No Records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /row-->

        </div>
        <!-- /page-with-sidebar -->



    </div>
    <!-- /row -->
    </div>

@stop
