<p>Hi Admin,</p>

<div>
    We have a enquiry for Pets Master from {{ $user_email }} .
    <br><br>
    Breed Type : {{ $breed_type }}
    <br><br>
    Breed Name : {{ $breed_name }}
    <br><br>
    Breed Gender : {{ $breed_gender }}
    <br><br>
    Breed DOB : {{ $breed_dob }}
    <br><br>
    Breed Weight : {{ $breed_weight }} KG
    <br><br>
    What’s their activity level? : {{ $breed_activity_level }}
    <br><br>
    @if ($breed_freedom_level != '')
        What’s their level of freedom? : {{ $breed_freedom_level }}
        <br><br>
    @endif
    Is your pet neutered/spayed? : {{ $breed_neutered }}
    <br><br>
    What do you want to achieve with their weight? : {{ $breed_weight_motive }}
    <br><br>
    Does your pet have any allergies? : {{ $breed_allergies }}
    <br><br>
    @if ($breed_allergies_info != '')
        Allergy Information : {{ $breed_allergies_info }}
        <br><br>
    @endif
    Does your pet have any ongoing health conditions? : {{ $breed_health_condition }}
    <br><br>
    @if ($breed_health_condition_info != '')
        Health Condition Information : {{ $breed_health_condition_info }}
        <br><br>
    @endif
    Is your pet pregnant or nursing? : {{ $breed_nursing }}
    <br><br>
    @if ($breed_nursing_info != '')
        Nursing Information : {{ $breed_nursing_info }}
        <br><br>
    @endif
    Additional Information : {{ $breed_additional_note }}
    <br><br>

</div>
