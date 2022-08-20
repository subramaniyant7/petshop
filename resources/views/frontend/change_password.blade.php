@extends('frontend.layout')

@section('content')
    <div class="page container">
        <div class="row">
            @include('frontend.sidebar')
            <div class="col-lg-9 page-with-sidebar">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Change Password </h2>
                    </div>
                    <!-- /col-lg-->
                    @include('admin.notification')
                    <div class="col-lg-12 col-md-12">
                        <div id="contact_form">
                            <form method="post" action="{{ url(FRONTENDURL . 'save_password') }}" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Old Password <span class="required">*</span></label>
                                            <input type="password" name="user_old_password" class="form-control input-field"
                                                required="" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>New Password <span class="required">*</span></label>
                                            <input type="password" name="user_new_password" class="form-control input-field"
                                                required="" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Confirm Password <span class="required">*</span></label>
                                            <input type="password" name="user_confirm_password" class="form-control input-field"
                                                required="" value="">
                                        </div>
                                    </div>

                                    <button type="submit" id="submit_btn" value="Submit"
                                        class="btn btn-primary">Submit</button><br/><br/>

                                        <span>Note : Once you changed the password it will logout automatically</span>
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
