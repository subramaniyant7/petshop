<head>
    <meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>Control Panel - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="description" content="Untame Cpanel" />
	<meta name="keywords" content="admin" />
	<meta name="author" content="untame"/>
    <link rel="icon" type="image/x-icon" href="{{ URL::asset(FRONTEND.'/img/favicon.png')}}">
	<!-- Favicon -->
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="icon" href="favicon.ico" type="image/x-icon">

	<!-- Data table CSS -->
	<link href="{{ URL::asset(ADMIN.'/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ URL::asset(ADMIN.'/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Bootstrap Colorpicker CSS -->
    <link href="{{ URL::asset(ADMIN.'/vendors/bower_components/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- select2 CSS -->
    <link href="{{ URL::asset(ADMIN.'/vendors/bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- switchery CSS -->
    <link href="{{ URL::asset(ADMIN.'/vendors/bower_components/switchery/dist/switchery.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- bootstrap-select CSS -->
    <link href="{{ URL::asset(ADMIN.'/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- bootstrap-tagsinput CSS -->
    <link href="{{ URL::asset(ADMIN.'/vendors/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css"/>

    <!-- bootstrap-touchspin CSS -->
    <link href="{{ URL::asset(ADMIN.'/vendors/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- multi-select CSS -->
    <link href="{{ URL::asset(ADMIN.'/vendors/bower_components/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Bootstrap Switches CSS -->
    <link href="{{ URL::asset(ADMIN.'/vendors/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Bootstrap Datetimepicker CSS -->
    <link href="{{ URL::asset(ADMIN.'/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>


    <!--alerts CSS -->
    <link href="{{ URL::asset(ADMIN.'/vendors/bower_components/sweetalert/dist/sweetalert.css') }}" rel="stylesheet" type="text/css">


	<!-- Custom CSS -->
	<link href="{{ URL::asset(ADMIN.'/dist/css/style.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::asset(ADMIN.'/dist/css/custom.css') }}" rel="stylesheet" type="text/css">


    <script>
        let siteurl = "{{ FRONTENDURL }}";
    </script>


</head>
