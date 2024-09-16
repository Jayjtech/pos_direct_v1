<table class="table table-hover">
    <thead>
        <tr>
            <th>{{ __('S/N') }}</th>
            <th>{{ __('Product') }}</th>
            <th>{{ __('Opening Qty') }}</th>
            <th>{{ __('Closing Qty') }}</th>
            <th>{{ __('Qty Sold') }}</th>
            <th>{{ __('Actual C. Price') }}</th>
            <th>{{ __('Actual S. Price') }}</th>
            <th>{{ __('Disc') }}</th>
            <th>{{ __('Net SP.') }}</th>
            <th>{{ __('Profit') }}</th>
        </tr>
    </thead>
    <tbody>
        @php
            $n = $total_qty = $total_dic = $total_oQ = $total_cQ = $net_sp = $total_cost_price = $total_selling_price = $total_profit = 0;
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
                    $total_cost_price = $total_cost_price + $data->sum->grand_cost_price;
                    $total_selling_price = $total_selling_price + $data->sum->grand_selling_price;
                    $profit = $sub_net_sp - $data->sum->grand_cost_price;
                    $total_profit = $total_profit + $profit;
                @endphp
                <tr>
                    <td>{{ $n }}</td>
                    <td class="font-weight-bold">{{ $product->name }}</td>
                    <td>{{ number_format($data->openingQty) }}</td>
                    <td>{{ number_format($data->closingQty) }}</td>
                    <td class="text-info font-weight-bold">{{ number_format($data->sum->qty_total) }}</td>
                    <td class="font-weight-bold">
                        {!! config('basic.c_s') !!}{{ number_format($data->sum->grand_cost_price) }}
                    </td>
                    <td class="font-weight-bold">
                        {!! config('basic.c_s') !!}{{ number_format($data->sum->grand_selling_price) }}
                    </td>
                    <td class="font-weight-bold text-danger">
                        {!! config('basic.c_s') !!}{{ number_format($data->sum->disc_total) }}</td>
                    <td class="font-weight-bold">{!! config('basic.c_s') !!}{{ number_format($sub_net_sp) }}
                    </td>
                    <td class="font-weight-bold {{ $profit < 0 ? 'text-danger' : 'text-success' }}">
                        {!! config('basic.c_s') !!}{{ number_format($profit) }}</td>
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
            <th>{!! config('basic.c_s') !!}{{ number_format($total_cost_price) }}</th>
            <th>{!! config('basic.c_s') !!}{{ number_format($total_selling_price) }}</th>
            <th class="text-danger">{!! config('basic.c_s') !!}{{ number_format($total_dic) }}</th>
            <th class="text-success">{!! config('basic.c_s') !!}{{ number_format($net_sp) }}</th>
            <th class="text-success">{!! config('basic.c_s') !!}{{ number_format($total_profit) }}</th>
        </tr>
    </tbody>
</table>
