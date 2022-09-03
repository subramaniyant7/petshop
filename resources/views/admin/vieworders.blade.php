@extends('admin.layouts')

@section('title','Manage Orders')
@section('content')

<div class="container-fluid">


    @include('admin.notification')
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Orders Details</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table id="datable_1" class="table table-hover display  pb-30" >
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Order ID</th>
                                            <th>User</th>
                                            <th>Order Type</th>
                                            <th>Total Gram</th>
                                            <th>Total Price</th>
                                            <th>Delivery Date</th>
                                            <th>Payment Id</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $k => $order)
                                            @php
                                                $stClass = ($order->status == 1) ? 'label-success' : 'label-danger';
                                                $stTxt = ($order->status == 1) ? 'Active' : 'label-danger';
                                            @endphp
                                            <tr>
                                                <td>{{ $k+1 }}</td>
                                                <td>{{ $order->order_inc_id }}</td>
                                                <td>{{ getUser($order->user_id)[0]->user_email }}</td>
                                                <td>{{ $order->order_type == 1 ? 'Partial' : 'Complete' }}</td>
                                                <td>{{ $order->totalGram }}</td>
                                                <td>Rs.{{ number_format($order->totalPrice,2) }}</td>
                                                <td>{{ $order->delivery_date }}</td>
                                                <td>{{ $order->paymentId }}</td>
                                                <td class="text-nowrap">
                                                    <a href="{{ url(ADMINURL.'/vieworderdetails/'.encryption($order->order_id)) }}" class="mr-25" data-toggle="tooltip" data-original-title="View">
                                                        <i class="fa fa-eye text-inverse m-r-10"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
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


