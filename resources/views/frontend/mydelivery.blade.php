@extends('frontend.layout')

@section('content')
    <div class="page container">
        <div class="row">
            @include('frontend.sidebar')

            <div class="col-lg-9 page-with-sidebar">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Upcoming Delivery </h2>
                    </div>
                    <!-- /col-lg-->
                    @include('admin.notification')
                    <div class="col-lg-12 col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Delivery Date</th>
                                    <th>Quantity</th>
                                    {{-- <th>View Products</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    usort($totalDelivery, function ($a, $b) {
                                        return strcmp($a['delivery'], $b['delivery']);
                                    });
                                @endphp
                                @forelse ($totalDelivery as $k => $total)
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ date('d-m-Y', strtotime($total['delivery'])) }}</td>
                                        <td>{{ $total['gram'] }} Gram</td>
                                        {{-- <td><a href="{{ FRONTENDURL.'upcomingdelivery_product/'.encryption($total['orderid']) }}">View</a></td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No Delivery found</td>
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
