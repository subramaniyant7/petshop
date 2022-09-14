$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    $('#preloader').hide();

});

const getBreeds = (breedType) => {
    if (breedType != '') {
        $('#preloader').show();
        $.ajax({
            type: 'post',
            url: `${siteurl}getbreed`,
            data: { breedType: breedType },
            dataType: 'json',
            success: function (response) {
                let options = "<option value=''>Select</option>";
                if (response.status) {
                    if (response.data.length) {
                        window.location.href = response.action;
                    } else {
                        toastr.error('No Breed found. Please choose some other Breed Type');
                    }
                } else {
                    toastr.error('Something went wrong. Please try again');
                }
            },
            error: function (data) {
                toastr.error('Something went wrong. Please try again');
            },
            complete: function () {
                $('#preloader').hide();
            }
        });
    }
}

const breedAllergy = (allergyValue) => {
    let html = '';
    if (allergyValue == '1') {
        html = '<input type="text" style="margin-top: 2.3em;" required name="breed_allergies_info" placeholder="Allergy Information" class="form-control input-field">';
    }
    $('#allergyinfo').html(html);
}



const healthInfo = (healthCondition) => {
    let html = '';
    if (healthCondition == 1) {
        html = '<input type="text" style="margin-top: 2.3em;" required name="breed_health_condition_info" placeholder="Health Condition Information" class="form-control input-field">';
    }
    $('#healthcondition').html(html);
}

const breedNursing = (allergyValue) => {
    let html = '';
    if (allergyValue == '1') {
        html = '<input type="text" style="margin-top: 2.3em;" required name="breed_nursing_info" placeholder="Pregency/Nursing Information" class="form-control input-field">';
    }
    $('#breed_nursing').html(html);
}


const updateBalance = (val) => {
    let remainingGramToBuy = parseFloat($('input[name="remainingGramToBuy"]').val()) / 1000;
    let k = 0
    var input = document.getElementsByName('product_qty[]');
    for (let i = 0; i < input.length; i++) {
        if (input[i].value != '' && i > 0) {
            k = parseFloat(k) + parseFloat(input[i].value);
        }
    }
    let remainingToAdd = remainingGramToBuy - k;
    if(k > remainingGramToBuy){
        $('.submit_product').attr('disabled', true);
        toastr.error('You cannot order more than required food');
    }else{
       $('.remaining_product').html(remainingToAdd.toFixed(2))
    }

    console.log('remainingGramToBuy', remainingGramToBuy)
    console.log('k', k)

    if(k.toFixed(2) == remainingGramToBuy){
        $('.submit_product').attr('disabled', false);
    }
}


$('#order_proceed').submit(function(e){
    e.preventDefault();
    console.log('submit')

    $.ajax({
        type: 'post',
        url: `${siteurl}getorderproducts`,
        data: $('#order_proceed').serialize(),
        dataType: 'json',
        success: function (response) {
            console.log(response)
            return false
            if (response.status) {
                // if (response.data.length) {
                //     window.location.href = response.action;
                // } else {
                //     toastr.error('No Breed found. Please choose some other Breed Type');
                // }
            } else {
                toastr.error('Something went wrong. Please try again');
            }
        },
        error: function (data) {
            toastr.error('Something went wrong. Please try again');
        },
        complete: function () {
            $('#preloader').hide();
        }
    });

})

