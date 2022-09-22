<form method="POST" action="{{ url(FRONTENDURL . 'orderproceed') }}">
    @csrf
    <p style="text-align:right;font-weight:bold;color:red;">Remaining Quantity to Add : <span
            class="remaining_product">{{ $remainingGramToBuy / 1000 }}</span>
        KG</p>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>

            @csrf
            <tr>
                <td>1</td>
                <td><img style="min-height: 100px;max-height:100px;"
                        src="{{ URL::asset('uploads/products/' . $default->product_image) }}"></td>
                <td>
                    {{ $default->product_name }} (Starter Product - Mandatory)
                </td>
                <td>Rs.{{ $default->product_price }}/Gram</td>
                <td>
                    {{ $defaultProductCalc / 1000 }} KG
                    <input type="hidden" name="product_qty[]" value="{{ $defaultProductCalc }}">
                    <input type="hidden" name="product_id[]" value="{{ encryption($default->product_id) }}">
                </td>
            </tr>
            @foreach ($products as $k => $data)
                <tr>
                    <td>{{ $k + 2 }}</td>
                    <td><img style="min-height: 100px;max-height:100px;"
                            src="{{ URL::asset('uploads/products/' . $data->product_image) }}"></td>
                    <td>{{ $data->product_name }}</td>
                    <td>Rs.{{ $data->product_price }}/Gram</td>
                    <td>
                        <input type="number" name="product_qty[]" step="0.001" value="" onblur="updateBalance(this.value)">
                        <input type="hidden" name="product_id[]" value="{{ encryption($data->product_id) }}">
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>
    <input type="hidden" value="{{ $totalGramNeedtoBuy }}" name="totalGramNeedtoBuy">
    <input type="hidden" value="{{ $defaultProductCalc }}" name="defaultProductCalc">
    <input type="hidden" value="{{ $remainingGramToBuy }}" name="remainingGramToBuy">
    <input type="hidden" value="{{ $remainingDays }}" name="remainingDays">
    <input type="hidden" value="{{ $totalGram }}" name="totalGram">
    <input type="hidden" value="{{ $totalDays }}" name="totalDays">
    <input type="hidden" value="{{ $perDayMeal }}" name="perDayMeal">
    <input type="hidden" value="{{ request()->order_type }}" name="order_type">
    <input type="hidden" value="{{ $deliveryDate }}" name="delivery_date">

    <input type="hidden" value="{{ encryption($petsInfo->pets_master_id) }}" name="pets_master_id">
    <button type="submit" style="float:right" disabled value="Submit"
        class="btn btn-primary submit_product">Submit</button>
</form>

<p style="padding-top: 5em;font-weight: bold;">

        **A starter pack that will help your pet accustom to the change in diet will
        automatically be calculated and added to your cart. It will constitute food for
        the first five days in the following proportion

        10% - day 1, 25% - day 2, 50% - day 3, 75% - day 4, 100% - day 5.
    <br/>
        This is only for the first month and will not be a part of the monthly food
        requirement shown above as it’s a default selected option*


</p>
