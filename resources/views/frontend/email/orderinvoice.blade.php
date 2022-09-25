<div class="invoice-box" style="max-width: 800px;margin: auto;padding: 30px;box-shadow: 0 0 10px rgba(0, 0, 0, .15);font-size: 16px;line-height: 24px;font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;color: #555;">
    <table cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left;">
        <tr class="top">
            <td>
                <img src="http://127.0.0.1:8000/frontend/img/Final_Logo_UntamePets_01.jpg' alt="U N T A M E PETS" title="U N T A M E PETS"
                       />
            </td>
            <td style="vertical-align: top;">
                <table style="width: 100%;line-height: inherit;text-align: left;font-size: 15px">
                    <tr style="text-align: right">
                        <td style="padding: 5px;vertical-align: top; text-align: right">
                            <strong>Order ID </strong> : {{ $order[0]->order_inc_id }}
                        </td>

                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 5px;vertical-align: top;">
                <table style="width: 100%;line-height: inherit;text-align: left;">
                    <tr>
                        <td style="padding: 1px;vertical-align: top;">
                            <span style="font-weight: 600"><strong>Shipping Address</strong></span><br/>
                            <address>
                                {{ $address[0]->first_name }} {{ $address[0]->last_name }},<br>
                                {{ $address[0]->address1 }},<br>

                                @if($address[0]->address2 !='')
                                    {{ $address[0]->address2 }},<br>
                                @endif
                                @php
                                    $city = $address[0]->city == 1 ? 'Chennai' : '';
                                    $state = $address[0]->state == 1 ? 'Tamilnadu' : '';
                                    $country = $address[0]->country == 1 ? 'India' : '';
                                @endphp
                                {{ $city }},
                                {{ $state }},
                                {{ $country }},<br>
                                @if($address[0]->landmark !='')
                                    {{ $address[0]->landmark }},<br>
                                @endif
                                {{ $address[0]->zipcode }}.<br>
                            </address>
                        </td>
                    </tr>
                </table>
            </td>

        </tr>
        <tr>
            <td colspan="2" style="padding: 5px;vertical-align: top;margin-left:20%">
                <table style="width: 100%;line-height: inherit;text-align: left;">
                    <tr>
                        <td style="padding: 5px;vertical-align: top;">
                            <strong>Order Items</strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 5px;vertical-align: top;margin-left:20%;border: 1px solid #000;">
                <table style="width: 100%;line-height: inherit;text-align: left;">
                    <tr>
                        <td style="padding: 5px;vertical-align: top;width:40%;">
                            Items
                        </td>
                        <td style="padding: 5px;vertical-align: top;width:15%;">
                            Price
                        </td>
                        <td style="padding: 5px;vertical-align: top;width:10%;">
                            Qty
                        </td>
                        <td style="padding: 5px;vertical-align: top;width:15%;">
                            Total
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        @php
            $total = 0;
        @endphp
        @foreach($orderProducts as $product)
        <tr>
            <td colspan="2" style="padding: 5px;vertical-align: top;margin-left:20%;border: 1px solid #000;border-top: none;">
                <table style="width: 100%;line-height: inherit;text-align: left;">
                    <tr>
                        <td style="padding: 5px;vertical-align: top;width:40%;">
                            <span>{{ $product->product_name }}</span>
                        </td>
                        <td style="padding: 5px;vertical-align: top;width:15%;">
                            Rs. {{ number_format($product->product_price,2) }}
                        </td>
                        <td style="padding: 5px;vertical-align: top;width:10%;">
                            {{ $product->product_qty }} G
                        </td>
                        <td style="padding: 5px;vertical-align: top;width:15%;">
                            Rs. {{ number_format($product->product_qty * $product->product_price,2) }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        @endforeach

        <tr>
            <td colspan="2" style="vertical-align: top;margin-left:20%;padding-top: 10px">
                <table style="width: 100%;line-height: inherit;text-align: left;">
                    <tr>
                        <td style="vertical-align: top;width:77%;text-align: right">
                            <strong>Sub-Total</strong>
                        </td>
                        <td style="vertical-align: top;width:23%;text-align: center">
                            Rs. {{ number_format($order[0]->totalPrice,2) }}
                        </td>

                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="vertical-align: top;margin-left:20%;padding-top: 10px">
                <table style="width: 100%;line-height: inherit;text-align: left;">
                    <tr>
                        <td style="vertical-align: top;width:77%;text-align: right">
                            <strong>GST</strong>
                        </td>
                        <td style="vertical-align: top;width:23%;text-align: center">
                            Rs. {{ number_format($order[0]->gst,2) }}
                        </td>

                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="vertical-align: top;margin-left:20%;padding-top: 10px">
                <table style="width: 100%;line-height: inherit;text-align: left;">
                    <tr>
                        <td style="vertical-align: top;width:77%;text-align: right">
                            <strong>Grand-Total</strong>
                        </td>
                        <td style="vertical-align: top;width:23%;text-align: center">
                            Rs. {{ number_format($order[0]->grandTotal,2) }}
                        </td>

                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="padding: 5px;vertical-align: top;margin-left:20%">
                <table style="width: 100%;line-height: inherit;text-align: left;">
                    <tr>
                        <td style="padding: 5px;vertical-align: top;">
                            <br/><br/><br/>
                            <strong>Order Details</strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="padding: 5px;vertical-align: top;margin-left:20%">
                <table style="width: 100%;line-height: inherit;text-align: left;">
                    <tr>
                        <td style="padding: 5px;vertical-align: top;">
                            <strong>Order Type</strong> : {{ $order[0]->order_type == 1 ? 'Partial' : 'Complete' }}
                            <br/>
                            <strong>Delivery Date</strong> : {{ $order[0]->delivery_date }}
                            <br/>
                            <strong>Payment Id</strong> : {{ $order[0]->paymentId }}
                            <br/>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="padding: 5px;vertical-align: top;margin-left:20%">
                <table style="width: 100%;line-height: inherit;text-align: left;">
                    <tr>
                        <td style="padding: 5px;vertical-align: top;">
                            <strong>This Invoice is system generated</strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>


</div>
