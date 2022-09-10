@extends('admin.layouts')
@section('title', 'View Upcoming Delivery')
@section('content')
    <div class="container-fluid">
        @include('admin.notification')
        <!-- Row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">View Upcoming Delivery</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table id="datable_1" class="table table-hover display  pb-30">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Order ID</th>
                                                <th>User</th>
                                                <th>Quantity(Gram)</th>
                                                <th>Delivery Date</th>
                                                <th>View Products</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($alldelivery as $k => $order)
                                                @if (strtotime($order->delivery_date) >= strtotime(date('y-m-d')))
                                                    @php
                                                        $products = getMyDeliveryProducts($order->deliveryinfo_id);
                                                        $totalgram = 0;
                                                        foreach ($products as $product) {
                                                            $totalgram += $product->product_gram;
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $k + 1 }}</td>
                                                        <td>{{ $order->order_id }}</td>
                                                        <td>{{ getUser($order->user_id)[0]->user_email }}</td>
                                                        <td>{{ $totalgram }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($order->delivery_date)) }}</td>
                                                        <td class="text-nowrap">
                                                            <a href="{{ url(ADMINURL.'/view_delivery_products/'.encryption($order->deliveryinfo_id)) }}" class="mr-25" data-toggle="tooltip" data-original-title="View">
                                                                <i class="fa fa-eye text-inverse m-r-10"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No Delivery found</td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Row -->

    </div>


@stop
