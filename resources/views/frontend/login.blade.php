@extends('frontend.layout')


@section('content')
    <div class="page container">
        <div class="row">
            <!-- page with sidebar starts -->
            <div class="col-lg-9 page-with-sidebar">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Login </h2>
                    </div>
                    <!-- /col-lg-->
                    @include('admin.notification')
                    <div class="contact-info col-lg-12 mt-5 res-margin">
                        <!-- Form Starts -->
                        <div id="contact_form">
                            <form method="post" action="{{ url(FRONTENDURL . 'loginvalidate') }}" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Email Address <span class="required">*</span></label>
                                            <input type="email" name="user_email" class="form-control input-field"
                                                required="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Password</label>
                                            <input autocomplete="new-password" type="password" name="user_password" class="form-control input-field">
                                        </div>
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
