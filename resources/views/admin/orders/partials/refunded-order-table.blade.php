<table class="table table-bordered">
    <thead>
        <tr>
            <th width="15%">Buyer's Info</th>
            @can('order-report')
                <th width="10%">Attendant</th>
            @endcan
            <th width="40%">Order</th>
            <th width="10%">Date</th>
            <th width="5%" colspan="2">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($combined_orders as $sub)
            @php
                $buyer_details = json_decode($sub->buyer_details);
                $split_name = explode(' ', $sub->user->name);
                $attendant = end($split_name);
            @endphp
            <tr>
                <td>
                    <div class="">
                        <span>Name: {{ $buyer_details->buyer }}</span><br>
                        <span>Phone: {{ $buyer_details->phone }}</span><br>
                        <span>Address: {{ $buyer_details->address }}</span>
                    </div>
                </td>
                @can('order-report')
                    <td>{{ $attendant }}</td>
                @endcan

                {{-- SubOrder table --}}
                <td>
                    <div class="table-responsive" style="font-size: 8px;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="font-size: 11px;">Product</th>
                                    <th style="font-size: 11px;">Price</th>
                                    <th style="font-size: 11px;">Qty</th>
                                    <th style="font-size: 11px;">Disct</th>
                                    <th style="font-size: 11px;">Sub total</th>

                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $grand_total = 0;
                                @endphp
                                @foreach ($sub->orders as $prod)
                                    @php
                                        $grand_total = $grand_total + $prod->sub_total;
                                    @endphp
                                    <tr class="@if ($prod->status == 2) bg-info text-light @endif">
                                        <td style="font-size: 11px;" class="font-weight-bold">
                                            {{ $prod->product }}</td>
                                        <td style="font-size: 11px;">
                                            {!! config('basic.c_s') !!}{{ number_format($prod->unit_price) }}
                                        </td>
                                        <td style="font-size: 11px;">{{ $prod->qty }}</td>
                                        <td style="font-size: 11px;">{{ $prod->discount }}</td>
                                        <td style="font-size: 11px;">
                                            {!! config('basic.c_s') !!}{{ number_format($prod->sub_total) }}
                                        </td>

                                    </tr>
                                @endforeach
                                <tr>
                                    <td style="font-size: 11px;" colspan="4" class="font-weight-bold">Grand Total
                                    </td>
                                    <td style="font-size: 11px;" class="font-weight-bold">
                                        {!! config('basic.c_s') !!}{{ number_format($grand_total) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 11px;" colspan="4">Checkout Method</td>
                                    <td style="font-size: 11px;" class="font-weight-bold">
                                        {{ strtoupper($buyer_details->payment_method) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
                {{-- End of SubOrder table --}}
                <td>{{ dateFormatter($sub->updated_at) }}</td>

                <td>
                    @can('order-report')
                        @if ($sub->status == 2)
                            <div class="revoke-order">
                                <a href="#{{ $buyer_details->buyer ?? $sub->id }}" class="btn btn-sm btn-primary"
                                    data-id="{{ $sub->id }}" data-bs-toggle="modal"
                                    data-bs-target="#revokeOrder">Revoke</a>
                            </div>
                        @endif
                    @endcan
                </td>
            </tr>
        @empty
            <p class="alert alert-danger">Refunded order table is empty!</p>
        @endforelse
    </tbody>
</table>
