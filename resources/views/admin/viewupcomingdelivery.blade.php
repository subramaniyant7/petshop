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
                                                <th>Gram</th>
                                                <th>Delivery Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                usort($totalDelivery, function ($a, $b) {
                                                    return strcmp($a['delivery'], $b['delivery']);
                                                });
                                            @endphp

                                            @forelse ($totalDelivery as $k => $order)
                                                <tr>
                                                    <td>{{ $k + 1 }}</td>
                                                    <td>{{ $order['orderid'] }}</td>
                                                    <td>{{ getUser($order['user_id'])[0]->user_email }}</td>
                                                    <td>{{ $order['gram'] }} Gram</td>
                                                    <td>{{ date('d-m-Y', strtotime($order['delivery'])) }}</td>

                                                </tr>
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
