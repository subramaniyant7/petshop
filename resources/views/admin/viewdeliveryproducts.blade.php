@extends('admin.layouts')
@section('title', 'View Upcoming Delivery Products')
@section('content')
    <div class="container-fluid">
        @include('admin.notification')
        <!-- Row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">View Upcoming Delivery Products</h6>
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
                                                <th>Image</th>
                                                <th>Product Name</th>
                                                <th>Quantity(Gram)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($deliveryProducts as $k => $productInfo)
                                                @php
                                                    $product = getProducts($productInfo->product_id);
                                                    $image = count($product) ? $product[0]->product_image : '';
                                                @endphp
                                                 <tr>
                                                    <td>{{ $k + 1 }}</td>
                                                    <td><img style="min-height: 100px;max-height:100px;"
                                                        src="{{ URL::asset('uploads/products/' . $image) }}"></td>
                                                    <td>{{ $productInfo->product_name }}</td>

                                                    <td>{{ $productInfo->product_gram }} Gram</td>
                                                </tr>

                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No Delivery products found</td>
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
