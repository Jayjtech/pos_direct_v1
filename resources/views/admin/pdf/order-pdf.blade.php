@extends('layouts.pdf')
@section('content')
    <div class="table table-responsive">
        <p class="mb-2 font-weight-bold text-success">GRAND TOTAL:
            {{ config('basic.currency') }}{{ number_format($grand_total, 2) }}</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="15%">Buyer's Info</th>
                    @can('generate-receipt')
                        <th width="10%">Attendant</th>
                    @endcan
                    <th width="40%">Order</th>
                    <th width="10%">Date</th>
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
                        @can('generate-receipt')
                            <td>{{ $attendant }}</td>
                        @endcan

                        {{-- SubOrder table --}}
                        <td>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 11px;">Product</th>
                                            <th style="font-size: 11px;">Price</th>
                                            <th style="font-size: 11px;">Qty</th>
                                            <th style="font-size: 11px;">Dis(%)</th>
                                            <th style="font-size: 11px;">Sub total</th>
                                            <th style="font-size: 11px;"></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($sub->orders as $prod)
                                            <tr class="@if ($prod->status == 2) bg-info text-light @endif">
                                                <td style="font-size: 11px;" class="font-weight-bold">
                                                    {{ $prod->product }}</td>
                                                <td style="font-size: 11px;">
                                                    {{ config('basic.currency') }}{{ number_format($prod->unit_price, 2) }}
                                                </td>
                                                <td style="font-size: 11px;">{{ $prod->qty }}</td>
                                                <td style="font-size: 11px;">{{ $prod->discount }}</td>
                                                <td style="font-size: 11px;">
                                                    {{ config('basic.currency') }}{{ number_format($prod->sub_total, 2) }}
                                                </td>
                                                <td style="font-size: 11px;">
                                                    @if ($prod->status == 2)
                                                        <span>Refunded</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td style="font-size: 11px;" colspan="4" class="font-weight-bold">Grand Total
                                            </td>
                                            <td style="font-size: 11px;" class="font-weight-bold">
                                                {{ config('basic.currency') }}{{ number_format($sub->grand_total, 2) }}
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
                        <td>{{ dateFormatter($sub->created_at) }}</td>
                    </tr>
                @empty
                    <p class="alert alert-danger">Order table is empty!</p>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection
