@extends('frontend.layout')

@section('content')
    <div class="page container">
        <div class="row">
            <div class="col-lg-12 page-with-sidebar">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Upcoming Delivery Products</h2>
                    </div>
                    <!-- /col-lg-->
                    @include('admin.notification')
                    <div class="col-lg-12 col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($productInfo as $k => $productInfo)
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
                                        <td colspan="3" class="text-center">No Delivery Products found</td>
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
