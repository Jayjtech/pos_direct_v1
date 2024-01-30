@extends('layouts.receipt')
@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Sub total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order as $item)
                <tr>
                    <td>{{ $item->product }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{!! config('basic.c_s') !!} {{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ $item->discount }}</td>
                    <td>{!! config('basic.c_s') !!} {{ number_format($item->sub_total, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">Grand Total</td>
                <td>{!! config('basic.c_s') !!} {{ number_format($combined_order->grand_total, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4">Payment Method:</td>
                <td>{{ strtoupper($buyer_details->payment_method) }}</td>
            </tr>
        </tbody>
    </table>
@endsection
@include('admin.js.receipt_js')
