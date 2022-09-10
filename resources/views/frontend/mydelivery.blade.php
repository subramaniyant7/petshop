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
                                    <th>Quantity(Gram)</th>
                                    <th>View Products</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($totalDelivery as $k => $total)
                                    @if (strtotime($total->delivery_date) >= strtotime(date('y-m-d')))
                                        @php
                                            $products = getMyDeliveryProducts($total->deliveryinfo_id);
                                            $totalgram = 0;
                                            foreach ($products as $product) {
                                                $totalgram += $product->product_gram;
                                            }

                                        @endphp
                                        <tr>
                                            <td>{{ $k + 1 }}</td>
                                            <td>{{ date('d-m-Y', strtotime($total->delivery_date)) }}</td>
                                            <td>{{ $totalgram }}</td>
                                            <td><a
                                                    href="{{ FRONTENDURL . 'upcomingdelivery_product/' . encryption($total->deliveryinfo_id) }}">View</a>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No Delivery found</td>
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
