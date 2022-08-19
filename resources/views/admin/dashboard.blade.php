@extends('admin.layouts')

@section('title','Dashboard')

@section('content')
    <style>
        .common{
            border-radius: 10px;
            color:#fff !important;
            padding: 40px 0px;
            width: 100%;
            display: block;
        }
        .parent{
            position:relative;
            margin-bottom: 40px;
        }
        .common p:nth-child(1){
            position:absolute;
            top: 13px;
            left: 32px;
        }
        .common p:nth-child(2){
            position:absolute;
            right: 40px;
            font-size: 40px;
        }
    </style>
    <div class="container-fluid">

        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Dashboard</h5>
            </div>

        </div>
        <div class="reports">
            <div class="row">
               Dashboard
            </div>
        </div>

    </div>


@stop
