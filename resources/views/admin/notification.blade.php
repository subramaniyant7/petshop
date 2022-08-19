@if (session('success'))
    <!-- <div class="alert alert-success" style="padding:10px">
        {{ session('success') }}
    </div> -->

    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>{{ session('success') }}
    </div>
@endif
@if (session('error'))
    <!-- <div class="alert alert-danger" style="padding:10px">
        {{ session('error') }}
    </div> -->

    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> {{ session('error') }}
    </div>
@endif
