@extends('layouts.receipt')
@section('content')
    <table class="table table-striped" style="margin-top:-20px;">
        <thead>
            <tr>
                <th>Pdt</th>
                <th>Qty</th>
                <th>Price({!! config('basic.c_s') !!} )</th>
                <th>Disc({!! config('basic.c_s') !!} )</th>
                <th>S-Total({!! config('basic.c_s') !!} )</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order as $item)
                <tr>
                    <td>{{ $item->product }}</td>
                    <td>{{ number_format($item->qty) }}</td>
                    <td>{{ number_format($item->unit_price) }}</td>
                    <td>{{ number_format($item->discount) }}</td>
                    <td>{{ number_format($item->sub_total) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">Grand Total</td>
                <td>{!! config('basic.c_s') !!} {{ number_format($combined_order->grand_total) }}</td>
            </tr>
            <tr>
                <td colspan="4">Payment Method:</td>
                <td>{{ strtoupper($buyer_details->payment_method) }}</td>
            </tr>
        </tbody>
    </table>
@endsection
@include('admin.js.receipt_js')
