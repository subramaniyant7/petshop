$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});



function getVoucherList() {
    toastr.remove();
    const carrierId = $('#voucher_item_carrier_id :selected').val()
    if (carrierId != '') {
        $.ajax({
            type: "post",
            data: { 'carrierId': carrierId },
            url: siteurl + 'ecom_admin/getvouchers',
            success: function(res) {
                let options = "<option value=''>Select</option>";
                if (res.data.length) {
                    res.data.forEach(response => {
                        options += "<option value=" + response.voucher_id + ">" + response.voucher_selling_price + "</option>";
                    })
                } else {
                    toastr.error('No Vouchers available for that carrier');
                }
                $("select[name=voucher_item_voucher_id]").empty().append(options).selectpicker('refresh');
            },
            error: function(d) {
                toastr.error('Server Error, Please try again')
            }
        });
    }
}



$('#delete_record').on('click', function(e) {
    e.preventDefault();
    let action = $(this).attr('href');
    swal({
        title: "Are you sure want to delete?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#f8b32d",
        confirmButtonText: "Confirm!",
        cancelButtonText: "Cancel !",
        closeOnConfirm: true,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            window.location.replace(action);
        }
    });
    return false;
});

const toast = (type, msg, text = '') => {
    $.toast().reset('all');
    $("body").removeAttr('class');
    $.toast({ heading: msg, text: text, position: 'top-right', loader: false, icon: type, hideAfter: 5000 });
    return false;
}

let url = window.location.pathname;
let path = "actioncity";



const fetchState = () => {

    let value = $("select[name=country_id]").val();
    let state = $("input[name=hidestate_id]").val();

    if (value != '' && !isNaN(value)) {
        $.ajax({
            type: "POST",
            data: { 'country_id': value },
            url: siteurl + 'ecom_admin/getstatelist',
            success: function(res) {
                let option = '<option value="">Select</option>';
                if (res.data.length) {
                    let result = res.data;
                    result.forEach(function(element) {
                        let selected = element.state_id == state ? 'selected' : '';
                        option += '<option value="' + element.state_id + '" ' + selected + '>' + element.state_name + '</option>';
                    });
                } else {
                    toast('error', 'Aucune donnée disponible', 'Veuillez choisir un autre pays')
                }
                $("select[name=state_id]").empty().append(option).selectpicker('refresh');
            },
            error: function(d) {
                toast('error', 'Server Error', 'Veuillez réessayer')
            }
        });
    }
}

if (url.indexOf(path) != -1) {
    fetchState();
}

const UpdateLockCode = (current, id, orderincid) => {
    let inputElement = $(current).parent().find('.unlock_code');
    let code = inputElement.val()
    if (code != '' && id != '' && orderincid != '') {
        $('.loading').show();
        $.ajax({
            type: "POST",
            data: { 'product_unlock_code': code, 'order_item_id': id, 'order_inc_id': orderincid },
            url: siteurl + 'ecom_admin/updatelockcode',
            success: function(res) {
                $(inputElement).prop('disabled', true);
                $(current).prop('disabled', true);
                $('.loading').hide();
                toast('success', 'Success', 'Unlock Code successfully sent')
            },
            error: function(d) {
                toast('error', 'Server Error', 'Something went wrong . Please try again')
            }
        });
    }
}

const removeProduct = (prodId, userId) => {
    if (prodId != '') {
        $('.loading').show();
        $.ajax({
            type: "POST",
            data: { 'product_id': prodId, 'user_id': userId },
            url: siteurl + 'ecom_admin/deleteuserproduct',
            success: function(res) {
                $('.loading').hide();
                if (res) {
                    location.reload()
                } else {
                    toast('error', 'Server Error', 'Something went wrong . Please try again')
                }
            },
            error: function(d) {
                toast('error', 'Server Error', 'Something went wrong . Please try again')
            }
        });
    }
}

const addProductRow = () => {
    let elements = $('.custom_elements').html();
    $('.add_product').append(elements);
}


const getUserStatelist = () => {
    let value = $("select[name=address_user_country]").val();
    let state = $("input[name=hidestate_id]").val();

    if (value != '' && !isNaN(value)) {
        $.ajax({
            type: "POST",
            data: { 'country_id': value },
            url: siteurl + 'ecom_admin/getstatelist',
            success: function(res) {
                let option = '<option value="">Select</option>';
                $("select[name=address_city]").empty().append(option).selectpicker('refresh');
                if (res.data.length) {
                    let result = res.data;
                    result.forEach(function(element) {
                        let selected = element.state_id == state ? 'selected' : '';
                        option += '<option value="' + element.state_id + '" ' + selected + '>' + element.state_name + '</option>';
                    });
                } else {
                    toast('error', 'Aucune donnée disponible', 'Veuillez choisir un autre pays');
                }
                $("select[name=address_user_state]").empty().append(option).selectpicker('refresh');

                getUserCitylist();
            },
            error: function(d) {
                toast('error', 'Server Error', 'Veuillez réessayer')
            }
        });
    }
}



const getUserCitylist = () => {
    let country = $("select[name=address_user_country]").val();
    let state = $("select[name=address_user_state]").val();
    let city = $("input[name=hidecity_id]").val();

    if (state != '' && !isNaN(state) && country != '' && !isNaN(country)) {
        $.ajax({
            type: "POST",
            data: { 'country_id': country, 'state_id': state },
            url: siteurl + 'ecom_admin/getcitylist',
            success: function(res) {
                let option = '<option value="">Select</option>';
                if (res.data.length) {
                    let result = res.data;
                    result.forEach(function(element) {
                        let selected = element.city_id == city ? 'selected' : '';
                        option += '<option value="' + element.city_id + '" ' + selected + '>' + element.city_name + '</option>';
                    });
                } else {
                    toast('error', 'Aucune donnée disponible', 'Veuillez choisir un autre pays')
                }

                $("select[name=address_user_city]").empty().append(option).selectpicker('refresh');
            },
            error: function(d) {
                toast('error', 'Server Error', 'Veuillez réessayer')
            }
        });
    }
}

path = 'actionuser';
if (url.indexOf(path) != -1) {
    getUserStatelist();
}


const getBrands = () => {
    let category = $("select[name=sub_category_id]").val();

    if (url.indexOf('manageproduct') != -1 || url.indexOf('actionproduct') != -1) {
        category = $("select[name=product_category]").val();
    }
    let brandid = $("input[name=hide_subbrand_id]").val();

    if (url.indexOf('actionsubcategory') != -1) {
        brandid = $("input[name=hide_brandid]").val();
    }


    if (category != '' && !isNaN(category)) {

        console.log('demo get brands')
        $.ajax({
            type: "POST",
            data: { 'category_id': category },
            url: siteurl + 'ecom_admin/getbrands',
            success: function(res) {
                let option = '<option value="">Select</option>';
                console.log(res);
                if (res.data.length) {
                    let result = res.data;
                    result.forEach(function(element) {
                        let selected = element.brand_id == brandid ? 'selected' : '';
                        // let selected = '';
                        option += '<option value="' + element.brand_id + '" ' + selected + '>' + element.brand_name + '</option>';
                    });
                } else {
                    toast('error', 'Aucune donnée disponible', 'Veuillez choisir une autre catégorie')
                }

                if (url.indexOf('manageproduct') != -1 || url.indexOf('actionproduct') != -1) {
                    $("select[name=product_brand]").empty().append(option).selectpicker('refresh');
                } else {
                    $("select[name=sub_brand_id]").empty().append(option).selectpicker('refresh');
                }


            },
            error: function(d) {
                toast('error', 'Server Error', 'Veuillez réessayer')
            }
        });
    }
}


path = 'actionsubcategory';
if (url.indexOf('actionsubcategory') != -1 || url.indexOf('actionproduct') != -1) {
    getBrands();
}

const updateSubCateId = () => {
    let subcategory = $("select[name=product_subcategory]").val();
    $("input[name=hide_subcat_id]").val(subcategory);
}

const addRow = () => {
   let row = '';
    if (url.indexOf('actionblproduct') != -1) {
        let subImageCount = $("input[name=sub_imagecount]").val();
        if(subImageCount == 4){
            toast('error', 'Maximum Limit Reached', 'You Cannot add more than 4 sub images')
            return false;
        }
        row += '<div class="col-md-12"><div class="form-group">';
        row += '<label class="col-md-4 control-label mb-10 text-right">Sub Image <span class="help"> *</span></label>';
        row += '<div class="col-md-7"><input type="file" class="form-control mb-3" value="" name="product_more_image[]" required ></div>';
        row += '</div></div>';
        $('.add_image').append(row);
        $("input[name=sub_imagecount]").val(parseInt(subImageCount)+1);
    }else{
        row += '<div class="col-md-12"><div class="form-group"><label class="col-md-5 control-label mb-10 text-left">Sub Image</label>';
        row += '<div class="col-sm-7"><input type="file" class="form-control mb-3" value="" name="product_more_image[]" required >';
        row += '</div></div></div>';
        $('.add_image').append(row);
    }
}

const getSubCategorylist = () => {
    let category = $("select[name=product_category]").val();
    let brandid = $("select[name=product_brand]").val();
    let subcategory = $("input[name=hide_subcat_id]").val();


    if (url.indexOf('actionproduct') != -1) {
        brandid = $("input[name=hide_subbrand_id]").val()
    }

    console.log('sub')
    console.log(category)
    console.log(brandid)
    console.log(subcategory)

    if (category != '' && !isNaN(category)) {
        $.ajax({
            type: "POST",
            data: { 'category_id': category, 'brand_id': brandid },
            url: siteurl + 'ecom_admin/getsubcategory',
            success: function(res) {
                let option = '<option value="">Select</option>';
                console.log('sub categorylist')
                console.log(res);
                if (res.data.length) {
                    let result = res.data;
                    result.forEach(function(element) {
                        let selected = element.subcategory_id == subcategory ? 'selected' : '';
                        option += '<option value="' + element.subcategory_id + '" ' + selected + '>' + element.subcategory_name + '</option>';
                    });
                } else {
                    toast('error', 'Aucune donnée disponible', 'Please choose other Category')
                }
                $("select[name=product_subcategory]").empty().append(option).selectpicker('refresh');
            },
            error: function(d) {
                toast('error', 'Server Error', 'Veuillez réessayer')
            }
        });
    }
}

path = 'actionproduct';
if (url.indexOf('actionproduct') != -1) {
    getSubCategorylist();
}

const importtype = () => {
    let import_type = $("select[name=import_type]").val();
    $("#sample_file").attr("href", "").hide();
    if (import_type != '') $("#sample_file").attr("href", siteurl + "ecom_admin/downloadsamplefile/" + import_type).show();
}

const productType = () => {
    let productType = $("select[name=product_type]").val();
    if (productType == 2) {
        $('.product_attr').show().find('.product_attribute').attr('required', true);
    } else {
        $('.product_attr').hide().find('.product_attribute').attr('required', false)
    }
}


// BLStore
const getBlProductType = (id,proId ='') => {
    console.log(id)

    if (id != '') {
        $.ajax({
            type: "get",
            data: { 'categoryId': id },
            url: siteurl + 'ecom_admin/getblproducttype',
            success: function(res) {
                let option = '<option value="">Select</option>';
                console.log(res);
                if (res.data.length) {
                    let result = res.data;
                    result.forEach(function(element) {
                        let selected = element.blproduct_type_id == proId ? 'selected' : '';
                        option += '<option value="' + element.blproduct_type_id + '" ' + selected + '>' + element.blproduct_type_name + '</option>';
                    });
                } else {
                    toast('error', 'No Product Type Data Found', 'Please choose other Category')
                }
                $("select[name=blproduct_producttype]").empty().append(option).selectpicker('refresh');
            },
            error: function(d) {
                toast('error', 'Server Error', 'Please try again later')
            }
        });
    }
}

const getBlSubCategory = (id,subId='') => {
    console.log(id)

    if (id != '') {
        let productType = 20;
        $.ajax({
            type: "get",
            data: { 'productType': id },
            url: siteurl + 'ecom_admin/getblsubcategory',
            success: function(res) {
                let option = '<option value="">Select</option>';
                console.log(res);
                if (res.data.length) {
                    let result = res.data;
                    result.forEach(function(element) {
                        let selected = element.blsubcategory_id == subId ? 'selected' : '';
                        option += '<option value="' + element.blsubcategory_id + '" ' + selected + '>' + element.blsubcategory_product_subcategory_name + '</option>';
                    });
                } else {
                    toast('error', 'No Subcategory Data Found', 'Please choose other Product Type')
                }
                $("select[name=blproduct_subcategory]").empty().append(option).selectpicker('refresh');
            },
            error: function(d) {
                toast('error', 'Server Error', 'Please try again later')
            }
        });
    }
}


if (url.indexOf('actionblproduct') != -1) {
    let categoryId = $("input[name=hide_category_id]").val();
    let productTypeId = $("input[name=hide_productType_id]").val();
    let subCategoryId = $("input[name=hide_subcategory_id]").val();
    if(categoryId !='') getBlProductType(categoryId,productTypeId)
    if(productTypeId !='') getBlSubCategory(productTypeId,subCategoryId)
}
