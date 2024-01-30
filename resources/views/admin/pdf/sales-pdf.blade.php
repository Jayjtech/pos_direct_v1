@extends('layouts.pdf')
@section('content')
    <div class="table table-responsive">
        <p class="mb-2 font-weight-bold text-success">GRAND TOTAL:
            {{ config('basic.currency') }}{{ number_format($grand_total, 2) }}</p>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Product</th>
                    <th>Quantity sold </th>
                    <th>Sub total </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $n = 0;
                @endphp
                @forelse ($products as $product)
                    @php
                        $n++;
                        /**Return sum of necessary columns*/
                        $sum = getProductSales($startDate, $endDate, $product->id)->sum;
                    @endphp
                    @if ($sum->qty_total != null)
                        <tr>
                            <td>{{ $n }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ number_format($sum->qty_total, 1) }}</td>
                            <td>
                                {!! config('basic.currency') !!}{{ number_format($sum->grand_total, 2) }}</td>
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

            </tbody>
        </table>

    </div>
@endsection
