@extends('frontend.layout')

@section('content')
    <div class="page container">
        <div class="row">
            @include('frontend.sidebar')

            <div class="col-lg-9 page-with-sidebar">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>My Subscription </h2>
                    </div>
                    <!-- /col-lg-->
                    @include('admin.notification')
                    <div class="col-lg-12 col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Order Id</th>
                                    <th>Subscribed On</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($subscription as $k => $subscription)
                                @php
                                    $orderInfo = getOrderById($subscription->order_id);
                                    $orderId = count($orderInfo) ? $orderInfo[0]->order_inc_id : '';
                                @endphp
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ $orderId }}</td>
                                        <td>{{ date('d-m-Y', strtotime($subscription->created_at)) }}</td>
                                        <td>{{ $subscription->status == 1 ? 'Subscribed' : 'Unsubscribed' }} </td>
                                        <td>
                                            @if ($subscription->status == 1)
                                                <a
                                                    href="{{ FRONTENDURL . 'update_subscription/' . encryption($subscription->subscription_id) }}">
                                                    Unsubscribe</a>
                                                    @else
                                                    -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No Subscription available</td>
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
