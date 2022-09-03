@extends('frontend.layout')


@section('content')
    <div class="page container">
        @include('admin.notification')
        <div class="row">
            <!-- page with sidebar starts -->
            <div class="col-lg-9 page-with-sidebar">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Register</h2>
                    </div>
                    <!-- /col-lg-->
                    <div class="contact-info col-lg-12 mt-5 res-margin">
                        <!-- Form Starts -->
                        <div id="contact_form">
                            <form method="post" action="{{ url(FRONTENDURL . 'register') }}" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>User Name <span class="required">*</span></label>
                                            <input type="text" name="user_firstname" class="form-control input-field"
                                                required="">
                                        </div>
                                        {{-- <div class="col-md-6">
                                            <label>Last Name <span class="required">*</span></label>
                                            <input type="text" name="user_last_name" class="form-control input-field"
                                                required="">
                                        </div> --}}
                                        <div class="col-md-6">
                                            <label>Email Address <span class="required">*</span></label>
                                            <input type="email" name="user_email" class="form-control input-field"
                                                required="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Mobile Number <span class="required">*</span></label>
                                            <input type="number" name="user_mobile" class="form-control input-field"
                                                required="">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Password <span class="required">*</span></label>
                                            <input autocomplete="new-password" type="password" name="user_password" class="form-control input-field" required="">
                                        </div>
                                    </div>
                                    <div class="row">

                                        {{-- <div class="col-md-6">
                                            <label>Mobile Number <span class="required">*</span></label>
                                            <input type="number" name="user_mobile" class="form-control input-field"
                                                required="">
                                        </div> --}}
                                        {{-- <div class="col-md-6">
                                            <label>Gender<span class="required">*</span></label>
                                            <select name="user_gender" class="form-control input-field" required="">
                                                <option value="">Select </option>
                                                <option value="1">Male </option>
                                                <option value="2">Female </option>
                                            </select>
                                        </div> --}}
                                    </div>
                                    <div class="row">

                                    </div>

                                    <button type="submit" id="submit_btn" value="Submit"
                                        class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                            <!-- /form-group-->
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
