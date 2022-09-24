@extends('frontend.layout')

@section('content')
    <div class="page container">
        <div class="row">
            @include('frontend.sidebar')

            <div class="col-lg-9 page-with-sidebar">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>My Upcoming Due </h2>
                    </div>
                    <!-- /col-lg-->
                    @include('admin.notification')
                    <div class="col-lg-12 col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Breed Type</th>
                                    <th>Pet Name</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($userOrders as $k => $orders)
                                    @php
                                        $gram = number_format($orders->remainingGramToBuy / $orders->remainingDays, 2);

                                        $breedName = $petName = '';
                                        $petsInfo = getPetMaster($orders->pets_master_id);
                                        if (count($petsInfo)) {
                                            $breedName = productFor()[$petsInfo[0]->breed_type - 1];
                                            $petName = $petsInfo[0]->pet_name;
                                        }

                                        $paid = false;
                                        foreach ($dueOrders as $due) {
                                            if ($due->parent_order_id == $orders->order_id && date('m')+1 == date('m', strtotime($due->transactionMonth))) {
                                                $paid = true;
                                                break;
                                            }
                                        }

                                    @endphp

                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ $breedName }}</td>
                                        <td>{{ $petName }}</td>
                                        <td>{{ ($gram * $totalDays) / 1000 }} KG</td>
                                        <td>Rs.{{ number_format($orders->grandTotal, 2) }}</td>
                                        <td>
                                            @php
                                                $paid = false;
                                                foreach ($dueOrders as $due) {
                                                    if ($due->parent_order_id == $orders->order_id && date('m')+1 == date('m', strtotime($due->transactionMonth))) {
                                                        $paid = true;
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            @if ($paid)
                                                Paid
                                            @else
                                                <form action="{{ url(FRONTENDURL . 'upcoming_due') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="orderId" value="{{ $orders->order_id }}">
                                                    <input type="hidden" name="perDay" value="{{ $orders->perDayMeal }}">
                                                    <input type="hidden" name="remainingDays"
                                                        value="{{ $orders->remainingDays }}">
                                                    <input type="hidden" name="totalDays" value="{{ $totalDays }}">
                                                    <input type="hidden" name="totalValue"
                                                        value="{{ $orders->perDayMeal * $totalDays }}">
                                                    <button type="submit"
                                                        style="border-radius: 10px;
                                                background: #044B16;
                                                color: #fff;
                                                border-color: #044B16;
                                                cursor: pointer;">Pay
                                                        Now</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No Records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
