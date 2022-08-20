@extends('frontend.layout')

@section('content')
    <div class="page container">
        <div class="row">
            @include('frontend.sidebar')
            <div class="col-lg-9 page-with-sidebar">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Action Shipping Address </h2>
                    </div>
                    <!-- /col-lg-->
                    @include('admin.notification')
                    <div class="col-lg-12 col-md-12">
                        <div id="contact_form">
                            <form method="post" action="{{ url(FRONTENDURL . 'saveshippingaddress') }}" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>First Name <span class="required">*</span></label>
                                            <input type="text" name="first_name" class="form-control input-field"
                                                required="" value="{{isset($data) ? $data[0]->first_name : old('first_name')}}">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Last Name <span class="required">*</span></label>
                                            <input type="text" name="last_name" class="form-control input-field"
                                                required="" value="{{isset($data) ? $data[0]->last_name : old('last_name')}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Address 1 <span class="required">*</span></label>
                                            <input type="text" name="address1" class="form-control input-field"
                                                required="" value="{{isset($data) ? $data[0]->address1 : old('address1')}}">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Address 2</label>
                                            <input type="text" name="address2" class="form-control input-field" value="{{isset($data) ? $data[0]->address2 : old('address2')}}">
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <label>City<span class="required">*</span></label>
                                            <select name="city" class="form-control input-field" required="">
                                                <option value="">Select </option>
                                                @foreach (userCity() as $k => $city)
                                                    <option value="{{ $k + 1 }}" selected>{{ $city }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label>State<span class="required">*</span></label>
                                            <select name="state" class="form-control input-field" required="">
                                                <option value="">Select </option>
                                                @foreach (userState() as $k => $city)
                                                    <option value="{{ $k + 1 }}" selected>{{ $city }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Country<span class="required">*</span></label>
                                            <select name="country" class="form-control input-field" required="">
                                                <option value="">Select </option>
                                                @foreach (userCountry() as $k => $city)
                                                    <option value="{{ $k + 1 }}" selected>{{ $city }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Landmark</label>
                                            <input type="text" name="landmark" class="form-control input-field" value="{{isset($data) ? $data[0]->landmark : old('landmark')}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Zipcode<span class="required">*</span></label>
                                            <input type="number" name="zipcode" class="form-control input-field" required="" value="{{isset($data) ? $data[0]->zipcode : old('zipcode')}}">
                                        </div>
                                    </div>
                                    <input type="hidden" name="user_address_id" class="form-control input-field" value="{{ isset($data) ? encryption($data[0]->user_address_id) : ''}}">
                                    <button type="submit" id="submit_btn" value="Submit"
                                        class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                            <!-- /form-group-->
                        </div>
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
