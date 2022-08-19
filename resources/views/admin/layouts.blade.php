<!DOCTYPE html>
<html lang="en">

@include('admin.header')

<body>
    @include('admin.loader')
    <div class="wrapper theme-6-active pimary-color-yellow">

		@include('admin.topmenu')
        @include('admin.customloader')
        @include('admin.sidebar')

		<!-- Right Sidebar Backdrop -->
		<div class="right-sidebar-backdrop"></div>
		<!-- /Right Sidebar Backdrop -->

        <!-- Main Content -->
		<div class="page-wrapper">

            @yield('content')

			@include('admin.footer')

		</div>
        <!-- /Main Content -->

    </div>
    <!-- /#wrapper -->

	<!-- JavaScript -->

    <!-- jQuery -->
    <script src="{{ URL::asset(ADMIN.'/vendors/bower_components/jquery/dist/jquery.min.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ URL::asset(ADMIN.'/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

	<!-- Data table JavaScript -->
	<script src="{{ URL::asset(ADMIN.'/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset(ADMIN.'/dist/js/dataTables-data.js') }}"></script>

    <!-- Moment JavaScript -->
    <script type="text/javascript" src="{{ URL::asset(ADMIN.'/vendors/bower_components/moment/min/moment-with-locales.min.js') }}"></script>

    <!-- Bootstrap Colorpicker JavaScript -->
    <script src="{{ URL::asset(ADMIN.'/vendors/bower_components/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>

    <!-- Select2 JavaScript -->
    <script src="{{ URL::asset(ADMIN.'/vendors/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

    <!-- Bootstrap Select JavaScript -->
    <script src="{{ URL::asset(ADMIN.'/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>

    <!-- Bootstrap Tagsinput JavaScript -->
    <script src="{{ URL::asset(ADMIN.'/vendors/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

    <!-- Bootstrap Touchspin JavaScript -->
    <script src="{{ URL::asset(ADMIN.'/vendors/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>

    <!-- Multiselect JavaScript -->
    <script src="{{ URL::asset(ADMIN.'/vendors/bower_components/multiselect/js/jquery.multi-select.js') }}"></script>

    <!-- Bootstrap Switch JavaScript -->
    <script src="{{ URL::asset(ADMIN.'/vendors/bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>

    <!-- Bootstrap Datetimepicker JavaScript -->
    <script type="text/javascript" src="{{ URL::asset(ADMIN.'/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

    <!-- Form Advance Init JavaScript -->
    <script src="{{ URL::asset(ADMIN.'/dist/js/form-advance-data.js') }}"></script>

	<!-- Slimscroll JavaScript -->
	<script src="{{ URL::asset(ADMIN.'/dist/js/jquery.slimscroll.js') }}"></script>

	<!-- simpleWeather JavaScript -->
	<script src="{{ URL::asset(ADMIN.'/vendors/bower_components/moment/min/moment.min.js') }}"></script>
	<script src="{{ URL::asset(ADMIN.'/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js') }}"></script>
	<script src="{{ URL::asset(ADMIN.'/dist/js/simpleweather-data.js') }}"></script>

	<!-- EChartJS JavaScript -->
	<script src="{{ URL::asset(ADMIN.'/vendors/bower_components/echarts/dist/echarts-en.min.js') }}"></script>
	<script src="{{ URL::asset(ADMIN.'/vendors/echarts-liquidfill.min.js') }}"></script>

	<!-- Progressbar Animation JavaScript -->
	<script src="{{ URL::asset(ADMIN.'/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js') }}"></script>
	<script src="{{ URL::asset(ADMIN.'/vendors/bower_components/jquery.counterup/jquery.counterup.min.js') }}"></script>

	<!-- Fancy Dropdown JS -->
	<script src="{{ URL::asset(ADMIN.'/dist/js/dropdown-bootstrap-extended.js') }}"></script>

	<!-- Sparkline JavaScript -->
	<script src="{{ URL::asset(ADMIN.'/vendors/jquery.sparkline/dist/jquery.sparkline.min.js') }}"></script>

	<!-- Owl JavaScript -->
	<script src="{{ URL::asset(ADMIN.'/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js') }}"></script>

	<!-- Toast JavaScript -->
	<script src="{{ URL::asset(ADMIN.'/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js') }}"></script>

	<!-- Piety JavaScript -->
	<script src="{{ URL::asset(ADMIN.'/vendors/bower_components/peity/jquery.peity.min.js') }}"></script>
	<script src="{{ URL::asset(ADMIN.'/dist/js/peity-data.js') }}"></script>

	<!-- Switchery JavaScript -->
	<script src="{{ URL::asset(ADMIN.'/vendors/bower_components/switchery/dist/switchery.min.js') }}"></script>


	<!-- Sweet-Alert  -->
    <script src="{{ URL::asset(ADMIN.'/vendors/bower_components/sweetalert/dist/sweetalert.min.js') }}"></script>

	<script src="{{ URL::asset(ADMIN.'/dist/js/sweetalert-data.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset(FRONTENDJS.'/toastr.js') }}"></script>

	<!-- Init JavaScript -->
	<script src="{{ URL::asset(ADMIN.'/dist/js/init.js') }}"></script>
	<script src="{{ URL::asset(ADMIN.'/dist/js/custom.js') }}"></script>
	<!-- <script src="{{ URL::asset(ADMIN.'/dist/js/dashboard-data.js') }}"></script> -->



</body>

</html>
