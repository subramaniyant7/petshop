@extends('admin.layouts')

@section('title','Action Product')
@section('content')

	<div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Manage Product</h6>
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-primary btn-rounded" href="{{ url(ADMINURL.'/viewproduct') }}">
                                <i class="fa fa-arrow"> </i>  Back
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    @include('admin.notification')
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap mt-40">
                                <form method="post" action="{{ url(ADMINURL.'/saveproductdetails') }}" enctype='multipart/form-data'>
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-7 col-md-offset-3">

                                            <div class="col-md-12 mb-10">
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label mb-10">Product For <span class="help"> *</span></label>
                                                    <div class="col-md-8">
                                                        <select class="selectpicker" name="product_for" data-style="form-control btn-default btn-outline" required>
                                                            <option value="">Select</option>
                                                            @foreach (productFor() as $k => $productfor)
                                                                <option value="{{ $k+1 }}" {{ ((isset($action) && $action == 'edit') && $data[0]->product_for == $k+1 ) ? 'selected' : '' }} >{{ $productfor }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label mb-10 text-left">Product Name<span class="help"> *</span></label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control mb-10" name="product_name" required
                                                         value ="{{ isset($action) && $action=='edit' ? $data[0]->product_name : old('product_name') }}"  >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label mb-10 text-left">Product Description<span class="help"> *</span></label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control mb-10" name="product_description" required
                                                         value ="{{ isset($action) && $action=='edit' ? $data[0]->product_description : old('product_description') }}"  >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label mb-10 text-left">Product Image<span class="help"> *</span></label>
                                                    <div class="col-md-8">
                                                        <input type="file" class="form-control mb-10" name="product_image" {{ isset($data) && $data[0]->product_image != '' ? '' : 'required' }}
                                                         value ="{{ isset($action) && $action=='edit' ? $data[0]->product_image : old('product_image') }}"  >
                                                         @if(isset($data) && $data[0]->product_image != '')
                                                         <span><img style="height: 200px;margin-top: 1em;" src="{{ URL::asset('uploads/products/'.$data[0]->product_image)}}"></span>
                                                     @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label mb-10 text-left">Product Price<span class="help"> *</span></label>
                                                    <div class="col-md-5">
                                                        <input type="number" step="any" class="form-control mb-10" name="product_price" required
                                                         value ="{{ isset($action) && $action=='edit' ? $data[0]->product_price : old('product_price') }}"  >
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select class="selectpicker" name="product_price_type" data-style="form-control btn-default btn-outline" required>
                                                            <option value="">Select</option>
                                                            @foreach (productType() as $k => $producttype)
                                                                <option value="{{ $k+1 }}" {{ ((isset($action) && $action == 'edit') && $data[0]->product_price_type == $k+1 ) ? 'selected' : '' }} >{{ $producttype }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-12 mb-10">
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label mb-10">Product Default <span class="help"> *</span></label>
                                                    <div class="col-md-8">
                                                        <select class="selectpicker" name="product_default" data-style="form-control btn-default btn-outline" required>
                                                            <option value="">Select</option>
                                                            @foreach (productDefault() as $k => $productdefault)
                                                            <option value="{{ $k+1 }}" {{ ((isset($action) && $action == 'edit') && $data[0]->product_default == $k+1 ) ? 'selected' : '' }} >{{ $productdefault }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            @if(isset($action) && $action =='edit')
                                            <div class="col-md-12 mb-10">
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label mb-10  text-left">Status<span class="help"> *</span></label>
                                                    <div class="col-md-8">
                                                        <select class="selectpicker" name="status" data-style="form-control btn-default btn-outline" required>
                                                            <option value="">Select</option>
                                                            @foreach (statustype() as $k => $statustype)
                                                                <option value="{{ $k+1 }}" {{ ((isset($action) && $action == 'edit') && $data[0]->status == $k+1 ) ? 'selected' : '' }} >{{ $statustype }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <input type="hidden" name="edit_productimage" value="{{ isset($data) ? $data[0]->product_image : '' }}">
                                            <input type="hidden" class="form-control mb-10" name="product_id"
                                                value ="{{ isset($action) && $action=='edit' ? encryption($data[0]->product_id) : '' }}"  >

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="col-md-4 control-label mb-10  text-left">  </label>
                                                        <button class="btn  btn-primary btn-rounded" type="submit">Save</button>
                                                        <a href="{{ url(ADMINURL.'/viewproduct') }}" class="btn btn-danger btn-rounded">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@stop
