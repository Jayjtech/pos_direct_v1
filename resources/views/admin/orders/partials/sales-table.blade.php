<table class="table table-hover">
    <thead>
        <tr>
            <th>{{ __('S/N') }}</th>
            <th>{{ __('Product') }}</th>
            <th>{{ __('Quantity sold') }}</th>
            <th>{{ __('Sub total') }}</th>
            {{-- <th>Action</th> --}}
        </tr>
    </thead>
    <tbody>
        @php
            $n = 0;
        @endphp
        @forelse ($products as $product)
            @php

                /**Return sum of necessary columns*/
                $sum = getProductSales($startDate, $endDate, $product->id)->sum;
                $n + 1;
            @endphp
            @if ($sum->qty_total != null)
                <tr>
                    <td>{{ $n }}</td>
                    <td class="font-weight-bold">{{ $product->name }}</td>
                    <td>{{ number_format($sum->qty_total, 1) }}</td>
                    <td class="font-weight-bold">
                        {!! config('basic.c_s') !!}{{ number_format($sum->grand_total, 2) }}</td>
                    {{-- <td>
                        <a href="" class="btn btn-sm btn-primary"><i class="mdi mdi-details"></i> Details</a>
                    </td> --}}
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
