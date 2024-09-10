<table class="table table-hover">
    <thead>
        <tr>
            <th>{{ __('S/N') }}</th>
            <th>{{ __('Product') }}</th>
            <th>{{ __('Opening Qty') }}</th>
            <th>{{ __('Closing Qty') }}</th>
            <th>{{ __('Qty sold') }}</th>
            <th>{{ __('Sub total') }}</th>
            <th>{{ __('Disc given') }}</th>
            <th>{{ __('Net SP.') }}</th>
        </tr>
    </thead>
    <tbody>
        @php
            $n = 0;
            $total_qty = 0;
            $total_dic = 0;
            $total_oQ = 0;
            $total_cQ = 0;
            $net_sp = 0;
        @endphp
        @forelse ($products as $product)
            @php
                /**Return sum of necessary columns*/
                $data = getProductSales($startDate, $endDate, $product->id);
            @endphp
            @if ($data->sum->qty_total != null)
                @php
                    $n++;
                    $sub_net_sp = $data->sum->grand_total;
                    $total_qty = $total_qty + $data->sum->qty_total;
                    $total_dic = $total_dic + $data->sum->disc_total;
                    $total_oQ = $total_oQ + $data->openingQty;
                    $total_cQ = $total_cQ + $data->closingQty;
                    $net_sp = $net_sp + $sub_net_sp;
                @endphp
                <tr>
                    <td>{{ $n }}</td>
                    <td class="font-weight-bold">{{ $product->name }}</td>
                    <td>{{ number_format($data->openingQty) }}</td>
                    <td>{{ number_format($data->closingQty) }}</td>
                    <td>{{ number_format($data->sum->qty_total) }}</td>
                    <td class="font-weight-bold">
                        {!! config('basic.c_s') !!}{{ number_format($data->sum->grand_total + $data->sum->disc_total) }}
                    </td>
                    <td class="font-weight-bold text-danger">
                        {!! config('basic.c_s') !!}{{ number_format($data->sum->disc_total) }}</td>
                    <td class="font-weight-bold text-success">{!! config('basic.c_s') !!}{{ number_format($sub_net_sp) }}
                    </td>
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
            <th>{!! config('basic.c_s') !!}{{ number_format($grand_total) }}</th>
            <th class="text-danger">{!! config('basic.c_s') !!}{{ number_format($total_dic) }}</th>
            <th class="text-success">{!! config('basic.c_s') !!}{{ number_format($net_sp) }}</th>
        </tr>
    </tbody>
</table>
