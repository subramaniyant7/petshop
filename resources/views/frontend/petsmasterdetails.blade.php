@extends('frontend.layout')

@section('content')
    <div class="page container">
        <div class="row">
            @include('frontend.sidebar')

            <div class="col-lg-9 page-with-sidebar">
                <div class="row">
                    @include('admin.notification')
                    <div class="col-lg-12">
                        <h2>Pets Master Details</h2>
                    </div>
                    <!-- /col-lg-->

                    <div class="col-lg-12 col-md-12">
                        <div id="contact_form">
                            <form method="post" action="{{ url(FRONTENDURL . 'savepetsmaster') }}" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Breed Type <span class="required">*</span></label>
                                            <select name="breed_type" class="form-control" required
                                                onchange="getBreeds(this.value)">
                                                <option value="">Select</option>
                                                @foreach (productFor() as $k => $breedtype)
                                                    <option value="{{ $k + 1 }}"
                                                        {{ $type == $k + 1 ? 'selected' : '' }}>{{ $breedtype }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($type != '')
                                            <div class="col-md-6">
                                                <label>Breed Name <span class="required">*</span></label>
                                                <select name="breed_name" id="breed_name" class="form-control" required>
                                                    <option value="">Select</option>
                                                    @foreach ($breeds as $breed)
                                                        <option value="{{ $breed->breed_id }}">{{ $breed->breed_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    </div>

                                    @if ($type != '')
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Gender <span class="required">*</span></label>
                                                <select name="breed_gender" class="form-control" required onchange="genderChange(this.value)">
                                                    <option value="">Select</option>
                                                    @foreach (petGender() as $k => $gender)
                                                        <option value="{{ $k + 1 }}">{{ $gender }}</option>
                                                    @endforeach

                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Date of Birth <span class="required">*</span></label>
                                                <input type="date" name="breed_dob" class="form-control input-field"
                                                    required value="">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>How much does your pet weight? <span
                                                        class="required">*</span></label>
                                                <input type="number" name="breed_weight" class="form-control input-field"
                                                    required value="">
                                            </div>

                                            <div class="col-md-6">
                                                <label>What’s their activity level? <span class="required">*</span></label>
                                                <select name="breed_activity_level" class="form-control" required>
                                                    <option value="">Select</option>
                                                    @if ($type == '1')
                                                        @foreach (dogActivity() as $k => $activity)
                                                            <option value="{{ $k + 1 }}">{{ $activity }}</option>
                                                        @endforeach
                                                    @elseif ($type == '2')
                                                        @foreach (catActivity() as $k => $activity)
                                                            <option value="{{ $k + 1 }}">{{ $activity }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>


                                        @if ($type == '2')
                                            <div class="row cat">
                                                <div class="col-md-12">
                                                    <label>What’s their level of freedom? <span
                                                            class="required">*</span></label>
                                                    <select name="breed_freedom_level" class="form-control" required>
                                                        <option value="">Select</option>
                                                        @foreach (catActivity() as $k => $activity)
                                                            <option value="{{ $k + 1 }}">{{ $activity }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Is your pet neutered/spayed? <span class="required">*</span></label>
                                                <select name="breed_neutered" class="form-control" required>
                                                    <option value="">Select</option>
                                                    @foreach (YesNo() as $k => $activity)
                                                        <option value="{{ $k + 1 }}">{{ $activity }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{-- </div>

                                        <div class="row"> --}}
                                            <div class="col-md-6">
                                                <label>What do you want to achieve with their weight? <span
                                                        class="required">*</span></label>
                                                <select name="breed_weight_motive" class="form-control" required>
                                                    <option value="">Select</option>
                                                    @foreach (acheiveWeight() as $k => $activity)
                                                        <option value="{{ $k + 1 }}">{{ $activity }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Does your pet have any allergies? <span
                                                        class="required">*</span></label>
                                                <select name="breed_allergies" class="form-control" required
                                                    onchange="breedAllergy(this.value)">
                                                    <option value="">Select</option>
                                                    @foreach (YesNo() as $k => $activity)
                                                        <option value="{{ $k + 1 }}">{{ $activity }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6" id="allergyinfo"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Does your pet have any ongoing health conditions? <span
                                                        class="required">*</span></label>
                                                <select name="breed_health_condition" class="form-control" required
                                                    onchange="healthInfo(this.value)">
                                                    <option value="">Select</option>
                                                    @foreach (YesNo() as $k => $activity)
                                                        <option value="{{ $k + 1 }}">{{ $activity }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6" id="healthcondition"></div>
                                        </div>

                                        <div class="row" id="breed_pregnant" style="display:none">
                                            <div class="col-md-6">
                                                <label>Is your pet pregnant or nursing? <span
                                                        class="required">*</span></label>
                                                <select name="breed_nursing" class="form-control"
                                                    onchange="breedNursing(this.value)">
                                                    <option value="">Select</option>
                                                    @foreach (YesNo() as $k => $activity)
                                                        <option value="{{ $k + 1 }}">{{ $activity }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6" id="breed_nursing"></div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Any additional notes you would like to add about your
                                                    pet?</label>
                                                <input type="text" name="breed_additional_note"
                                                    class="form-control input-field" value="">
                                            </div>
                                        </div>

                                        <button type="submit" id="submit_btn" value="Submit"
                                            class="btn btn-primary">Submit</button><br /><br />
                                    @endif


                                    <div style="margin-top:2em;">
                                        <h4>Note: </h4>
                                        <ul>
                                            <li>If your pet is under the age of 1, pregnant or nursing, their nutritional
                                                needs
                                                are different and we need more information before we can cater to them.
                                                Please fill in the pet
                                                profile and wait for us to get in touch with you! <br /><br /></li>
                                            <li>A starter pack gets automatically added for the first week to help your pet
                                                accustom to the
                                                change in diet. <br /><br /></li>
                                            <li>If you choose to get partial portions, please be aware that this is 50% of
                                                what your pet
                                                requires and will not be sufficient food for them. Make sure you substitute
                                                the
                                                remainder of
                                                the meal with their old food or something appropriate. </li>
                                        </ul>
                                    </div>



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

    <script>
        const genderChange = (val) => {
            console.log(val)
            if(val == 2){
                $('#breed_pregnant').show();
                $('select[name="breed_nursing"]').attr('required', true);
            }else{
                $('#breed_pregnant').hide();
                $('select[name="breed_nursing"]').attr('required', false).val();
                $('input[name="breed_nursing_info"]').attr('required', false);
                $('#breed_nursing').html();
            }
        }
    </script>

@stop
