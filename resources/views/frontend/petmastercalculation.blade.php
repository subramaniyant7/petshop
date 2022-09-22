@extends('frontend.layout')

@section('content')
    <div class="page container">
        <div class="row">


            <div class="col-lg-12 page-with-sidebar">
                <div class="row">

                    <div class="col-lg-12">
                        @include('admin.notification')
                        <h2>Pets Food Details</h2>
                    </div>
                    <!-- /col-lg-->

                    <div class="col-lg-12 col-md-12">
                        <div id="contact_form">
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="margin-top: 1em ">
                                        <p>Breed Type: {{ productFor()[$petsInfo->breed_type - 1] }}</p>
                                        <p>Breed Name:
                                            {{ $petsInfo->breed_name == 0 ? $petsInfo->breed_text : breedInfoById($petsInfo->breed_name)[0]->breed_name }}
                                        </p>
                                        <p>Pet Name : {{ $petsInfo->pet_name }}</p>
                                        <p>Breed Weight: {{ $petsInfo->breed_weight }} KG</p>
                                        <p>Per Day Meal : {{ $perDayMeal / 1000 }} KG</p>
                                        <p>Total Food need to feed for Month :
                                            {{ request()->order_type ? $totalGramNeedtoBuy / 1000 : $totalGram / 1000 }} KG
                                        </p>
                                    </div>
                                    @if (request()->order_type)
                                        @if (request()->order_type == 1)
                                            <p style="color:red">Please be aware that the partial option will only contain
                                                50% of the daily
                                                recommended food for your pet.
                                                The remaining 50% has to be supplemented by you with a species appropriate
                                                meal.</p>
                                        @endif
                                        @include('frontend.masterproducts')

                                    @else
                                        <form id="order_proceed1" method="GET">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label>Order Type <span class="required">*</span></label>
                                                    <select name="order_type" class="form-control" required>
                                                        <option value="">Select</option>
                                                        <option value="1">Partial</option>
                                                        <option value="2">Full</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <button type="submit" value="Submit"
                                                class="btn btn-primary">Submit</button><br /><br />
                                        </form>
                                    @endif
                                </div>
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
