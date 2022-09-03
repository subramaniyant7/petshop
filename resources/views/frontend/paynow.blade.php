@extends('frontend.layout')


@section('content')
    <div class="page container">
        <div class="row">
            <div class="col-lg-9 page-with-sidebar">
                <div class="row">

                    <div class="col-lg-12 col-md-12">
                        <div id="contact_form">
                            <div class="row">
                                <div class="col-md-12">

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Product</th>
                                                <th>Price(Gram)</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orderProductInfo as $k => $data)
                                                <tr>
                                                    <td>{{ $k + 1 }}</td>
                                                    <td>{{ $data->product_name }}</td>
                                                    <td>Rs.{{ $data->product_price }}</td>
                                                    <td>{{ $data->product_qty }}</td>
                                                    <td>{{ number_format($data->product_price * $data->product_qty,2) }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="3"></td>
                                                <td >Total</td>
                                                <td> Rs.{{ number_format($orderInfo[0]->totalPrice,2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <input type="hidden" id="total" value="{{ $orderInfo[0]->totalPrice }}">
                                    <input type="hidden" id="order_id" value="{{ encryption($orderInfo[0]->order_id) }}">
                                    <button type="button" style="float:right" value="Pay Now" id="rzp-button1" class="btn btn-primary">Pay
                                        Now</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                    <script>
                        let total = document.getElementById('total').value;
                        let orderId = document.getElementById('order_id').value;
                        // alert(total * 100)
                        var options = {
                            "key": "rzp_test_UUVQTAWGGCty5D", // Enter the Key ID generated from the Dashboard
                            "amount": total * 100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                            "currency": "INR",
                            "is_test_mode": true,
                            "name": "Untame Pet",
                            "description": "Test Transaction",
                            "merchant": {
                                "id": "KBn5evt4UQjsSf",
                                "name": "Untame Pet",
                                "image": "https:\/\/cdn.razorpay.com\/logos\/F05N9F3pgB1kEF_large.png",
                                "brand_color": "rgb(49,73,129)",
                                "brand_text_color": "#ffffff",
                                "branding_variant": "control",
                                "asterix_variant": "control"
                            },
                            "image": `${siteurl}frontend/img/Final_Logo_UntamePets_01.webp`,
                            // "order_id": "123243", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                            "handler": function(response) {
                                console.log(response)
                                if (response.razorpay_payment_id != '') {
                                    $('#preloader').show();
                                    $.ajax({
                                        url: `${siteurl}paymentsuccess`,
                                        type: 'post',
                                        dataType: 'json',
                                        data: {
                                            razorpay_payment_id: response.razorpay_payment_id,
                                            orderId: orderId,
                                        },
                                        success: function(data) {
                                            $('#preloader').hide();
                                            if (data.status) {
                                                window.location.href = data.url;
                                            } else {
                                                toastr.error(data.msg);
                                            }
                                        },
                                        error: function(e) {
                                            console.log(e)
                                            $('#preloader').hide();
                                            toastr.error('Something went wrong. Please try again');
                                            // location.reload();
                                        }
                                    });
                                } else {
                                    toastr.error('Something went wrong. Please try again');
                                    location.reload();
                                }
                                // alert(response.razorpay_payment_id);
                                // alert(response.razorpay_order_id);
                                // alert(response.razorpay_signature)
                            },
                            // "prefill": {
                            //     "name": "Gaurav Kumar",
                            //     "email": "gaurav.kumar@example.com",
                            //     "contact": "9999999999"
                            // },
                            "notes": {
                                "address": "Razorpay Corporate Office"
                            },
                            "theme": {
                                "color": "#3399cc"
                            }
                        };
                        var rzp1 = new Razorpay(options);
                        rzp1.on('payment.failed', function(response) {
                            toastr.error('Something went wrong. Please try again');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                            // alert(response.error.code);
                            // alert(response.error.description);
                            // alert(response.error.source);
                            // alert(response.error.step);
                            // alert(response.error.reason);
                            // alert(response.error.metadata.order_id);
                            // alert(response.error.metadata.payment_id);
                        });
                        document.getElementById('rzp-button1').onclick = function(e) {
                            rzp1.open();
                            e.preventDefault();
                        }
                    </script>

                </div>
            </div>
        </div>
    </div>
@stop
