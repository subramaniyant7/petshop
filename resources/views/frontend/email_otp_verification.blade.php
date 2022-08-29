@extends('frontend.layout')


@section('content')
    <div class="page container">
        <div class="row">

            <!-- page with sidebar starts -->
            <div class="col-lg-9 page-with-sidebar">
                <div class="row">

                    <div class="col-lg-12">
                        @include('admin.notification')
                        <h2>Email Verification </h2>
                    </div>
                    <!-- /col-lg-->

                    <div class="contact-info col-lg-12 mt-5 res-margin">
                        <!-- Form Starts -->
                        <div id="contact_form">
                            <form method="post" action="{{ url(FRONTENDURL . 'verify_otp_verify') }}" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Enter OTP <span class="required">*</span></label>
                                            <input type="number" name="user_otp" class="form-control input-field"
                                                required="">
                                        </div>
                                    </div>
                                    <input type="hidden" name="user_id" class="form-control input-field" value="{{request()->get('action')}}">
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
