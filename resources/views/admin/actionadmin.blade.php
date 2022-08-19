@extends('admin.layouts')

@section('title','Action Admin')
@section('content')

	<div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Manage Admin</h6>
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-primary btn-rounded" href="{{ url(ADMINURL.'/viewadmin') }}">
                                <i class="fa fa-arrow"> </i>  Back
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap mt-40">
                                <form method="post" action="{{ url(ADMINURL.'/saveadmindetails') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-5 col-md-offset-3">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label mb-10 text-left">Name<span class="help"> *</span></label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control mb-10" name="admin_name" required
                                                         value ="{{ isset($action) && $action=='edit' ? $data[0]->admin_name : old('admin_name') }}"  >
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-12 mb-10">
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label mb-10">Role <span class="help"> *</span></label>
                                                    <div class="col-md-8">
                                                        <select class="selectpicker" name="admin_role" data-style="form-control btn-default btn-outline" required>
                                                            <option value="">Select</option>
                                                            @foreach (admintype() as $k => $admintype)
                                                                <option value="{{ $k+1 }}" {{ ((isset($action) && $action == 'edit') && $data[0]->admin_role == $k+1 ) ? 'selected' : '' }} >{{ $admintype }}</option>
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

                                            <input type="hidden" class="form-control mb-10" name="admin_id"
                                                value ="{{ isset($action) && $action=='edit' ? encryption($data[0]->admin_id) : '' }}"  >

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="col-md-4 control-label mb-10  text-left">  </label>
                                                        <button class="btn  btn-primary btn-rounded" type="submit">Save</button>
                                                        <a href="{{ url(ADMINURL.'/viewadmin') }}" class="btn btn-danger btn-rounded">Cancel</a>
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
