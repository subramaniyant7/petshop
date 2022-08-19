@extends('admin.layouts')

@section('title','Change Password')
@section('content')

	<div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                @include('admin.notification')
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Change Password</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap mt-40">
                                <form method="post" action="{{ url(ADMINURL.'/change_password') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-7 col-md-offset-3">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label mb-10 text-left">Old Password<span class="help"> *</span></label>
                                                    <div class="col-md-8">
                                                        <input type="password" class="form-control mb-10" name="old_password" required
                                                         value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label mb-10 text-left">New Password<span class="help"> *</span></label>
                                                    <div class="col-md-8">
                                                        <input type="password" class="form-control mb-10" name="new_password" required
                                                         value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label mb-10 text-left">Confirm Password<span class="help"> *</span></label>
                                                    <div class="col-md-8">
                                                        <input type="password" class="form-control mb-10" name="confirm_password" required
                                                         value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" class="form-control mb-10" name="admin_id"
                                                value ="{{ encryption(session('admin_id')) }}"  >

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="col-md-5 control-label mb-10  text-left">  </label>
                                                        <button class="btn  btn-primary btn-rounded" type="submit">Save</button>
                                                    </div>
                                                </div>
                                                <span>Note : Once you changed the password it will logout automatically</span>
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
