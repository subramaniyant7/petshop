@extends('admin.layouts')

@section('title','Manage User')
@section('content')

<div class="container-fluid">


    @include('admin.notification')
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">User Details</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table id="datable_1" class="table table-hover display  pb-30" >
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile Number</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($userDetails as $k => $user)
                                            @php
                                                $stClass = ($user->status == 1) ? 'label-success' : 'label-danger';
                                                $stTxt = ($user->status == 1) ? 'Active' : 'label-danger';
                                            @endphp
                                            <tr>
                                                <td>{{ $k+1 }}</td>
                                                <td>{{ $user->user_firstname .' ' .$user->user_last_name }}</td>
                                                <td>{{ $user->user_email }}</td>
                                                <td>{{ $user->user_mobile }}</td>
                                                <td><span class="label {{ $stClass}}">{{ statustype()[$user->status-1] }}</span> </td>
                                            </tr>
                                        @endforeach
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


