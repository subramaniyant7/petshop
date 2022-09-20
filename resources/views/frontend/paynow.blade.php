@extends('frontend.layout')


@section('content')
    <div class="page container">
        <div class="row">
            <div class="col-lg-9 page-with-sidebar">
                <div class="row">

                    <div class="col-lg-12 col-md-12">
                        @include('admin.notification')
                        <div id="contact_form">
                            <div class="row">
                                <div class="col-md-12">

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Product</th>
                                                <th>Price(Gram)</th>
                                                <th>Quantity(KG)</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orderProductInfo as $k => $data)
                                                <tr>
                                                    <td>{{ $k + 1 }}</td>
                                                    <td>{{ $data->product_name }}</td>
                                                    <td>Rs.{{ $data->product_price }}</td>
                                                    <td>{{ $data->product_qty / 1000 }}</td>
                                                    <td>{{ number_format($data->product_price * $data->product_qty, 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @php
                                                $subTotalAmount = $orderInfo[0]->totalPrice;
                                                $gst = round(($subTotalAmount * 18) / 100);
                                                $grandTotal = $subTotalAmount + $gst;
                                            @endphp
                                            <tr>
                                                <td colspan="3"></td>
                                                <td>Sub Total</td>
                                                <td> Rs.{{ number_format($subTotalAmount, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td>GST</td>
                                                <td> Rs.{{ number_format($gst, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td>Grand Total</td>
                                                <td> Rs.{{ number_format($grandTotal, 2) }}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <form action="{{ url(FRONTENDURL . 'paymentprocess') }}" method="POST">
                                        @csrf
                                        <input type="hidden" id="subtotal" name="subtotal" value="{{ $subTotalAmount }}">
                                        <input type="hidden" id="gst" name="gst" value="{{ $gst }}">
                                        <input type="hidden" id="total" name="total" value="{{ $grandTotal }}">
                                        <input type="hidden" id="order_id" name="order_id"
                                            value="{{ $orderInfo[0]->order_id }}">
                                        <button type="submit" style="float:right" value="Pay Now"
                                            class="btn btn-primary" id="rzp-button">Pay
                                            Now</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script src="https://sdk.cashfree.com/js/core/1.0.26/bundle.sandbox.js"></script>
                    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                    <script>
                        let total = document.getElementById('total').value;
                        let orderId = document.getElementById('order_id').value;

                        const options = {
                            onPaymentSuccess: function(data) {
                                console.log("Success:", data);
                                /*
                                {
                                    order:{
                                            orderId: "some-orderid",
                                            orderStatus: "PAID"
                                    },
                                    transaction:{
                                        txStatus: "SUCCESS,
                                        txMsg: "Transaction Message",
                                        transactionId: 1232132,
                                        transactionAmount: 1.00
                                    }
                                }
                                */
                            },
                            onPaymentFailure: function(data) {
                                console.log("Failure:", data);
                                /*
                                {
                                    order:{
                                            orderId: "some-orderid",
                                            orderStatus: "ACTIVE"
                                    },
                                    transaction:{
                                        txStatus: "FAILED,
                                        txMsg: "Transaction Message",
                                        transactionId: 1232132,
                                        transactionAmount: 1.00
                                    }
                                }
                                */
                            },
                            onError: function(data) {
                                console.log("Error:", data);
                                /*
                                {
                                    message: "Invalid card number"
                                    paymentMode: "card"
                                    type: "input_validation_error"
                                }
                                */
                            },
                        };
                        const cfCheckout = Cashfree.initializeApp(options);
                        document.getElementById('rzp-button').onclick = function(e) {
                            cfCheckout.open();
                            e.preventDefault();
                        }

                        // alert(total * 100)
                        var options = {
                            "key": "rzp_test_UUVQTAWGGCty5D", // Enter the Key ID generated from the Dashboard
                            "amount": total *
                                100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
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
                                    let subtotal = $('#subtotal').val();
                                    let gst = $('#gst').val();
                                    $.ajax({
                                        url: `${siteurl}paymentsuccess`,
                                        type: 'post',
                                        dataType: 'json',
                                        data: {
                                            razorpay_payment_id: response.razorpay_payment_id,
                                            orderId: orderId,
                                            subtotal: subtotal,
                                            gst: gst
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
