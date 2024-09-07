@extends('layouts.pdf')
@section('content')
    <div class="table table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Product</th>
                    <th>Opening Qty</th>
                    <th>Closing Qty</th>
                    <th>Qty sold </th>
                    <th>Discount given </th>
                    <th>Sub total </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $n = 0;
                    $total_qty = 0;
                    $total_dic = 0;
                    $total_oQ = 0;
                    $total_cQ = 0;
                @endphp
                @forelse ($products as $product)
                    @php

                        /**Return sum of necessary columns*/
                        $data = getProductSales($startDate, $endDate, $product->id);
                    @endphp
                    @if ($data->sum->qty_total != null)
                        @php
                            $n++;
                            $total_qty = $total_qty + $data->sum->qty_total;
                            $total_dic = $total_dic + $data->sum->disc_total;
                            $total_oQ = $total_oQ + $data->openingQty;
                            $total_cQ = $total_cQ + $data->closingQty;
                        @endphp
                        <tr>
                            <td>{{ $n }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ number_format($data->openingQty) }}</td>
                            <td>{{ number_format($data->closingQty) }}</td>
                            <td>{{ number_format($data->sum->qty_total) }}</td>
                            <td>{{ config('basic.currency') }}{{ number_format($data->sum->disc_total) }}</td>
                            <td>
                                {{ config('basic.currency') }}{{ number_format($data->sum->grand_total, 2) }}</td>
                        </tr>
                    @endif
                @empty
                    <p class="alert alert-danger">
                        {{ __('The product table is empty!') }}
                    </p>
                @endforelse
                @if ($grand_total <= 0)
                    <tr>
                        <p class="alert alert-danger">
                            {{ __('Nothing was sold within the searched dates!') }}
                        </p>
                    </tr>
                @endif
                <tr>
                    <th colspan="2">Summary</th>
                    <th>{{ number_format($total_oQ) }}</th>
                    <th>{{ number_format($total_cQ) }}</th>
                    <th>{{ number_format($total_qty) }}</th>
                    <th>{{ config('basic.currency') }}{{ number_format($total_dic) }}</th>
                    <th>{{ config('basic.currency') }}{{ number_format($grand_total) }}</th>
                </tr>
            </tbody>
        </table>

    </div>
@endsection
