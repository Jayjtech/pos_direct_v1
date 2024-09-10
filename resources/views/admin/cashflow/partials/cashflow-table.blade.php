<table class="table table-hover">
    {{-- <thead>
       
    </thead> --}}
    <tbody>
        {{-- Cash flow --}}
        <tr>
            <th>{{ __('CASH INFLOW') }}</th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th>{{ __('Cash Sales') }}</th>
            <th>{!! config('basic.c_s') !!}{{ number_format($cash_sales->cash_total) }}</th>
            <th></th>
        </tr>
        <tr>
            <th>{{ __('TOTAL CASH INFLOW') }}</th>
            <th></th>
            <th>{!! config('basic.c_s') !!}{{ number_format($cash_sales->cash_total) }}</th>
        </tr>

        {{-- POS INFLOW --}}
        <tr>
            <th>{{ __('POS INFLOW') }}</th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th>{{ __('POS Sales') }}</th>
            <th>{!! config('basic.c_s') !!}{{ number_format($pos_sales->pos_total) }}</th>
            <th></th>
        </tr>
        <tr>
            <th>{{ __('TOTAL POS INFLOW') }}</th>
            <th></th>
            <th>{!! config('basic.c_s') !!}{{ number_format($pos_sales->pos_total) }}</th>
        </tr>

        {{-- BANK TRANSFER INFLOW --}}
        <tr>
            <th>{{ __('BANK INFLOW') }}</th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th>{{ __('Bank Transfer Sales') }}</th>
            <th>{!! config('basic.c_s') !!}{{ number_format($bank_sales->bank_total) }}</th>
            <th></th>
        </tr>
        <tr>
            <th>{{ __('TOTAL BANK INFLOW') }}</th>
            <th></th>
            <th>{!! config('basic.c_s') !!}{{ number_format($bank_sales->bank_total) }}</th>
        </tr>
        {{-- DISCOUNT --}}
        <tr>
            <th>{{ __('DISCOUNT') }}</th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th>{{ __('Total Discount') }}</th>
            <th class="text-danger">{!! config('basic.c_s') !!}{{ number_format($total_discount) }}</th>
            <th></th>
        </tr>
        {{-- DISCOUNT --}}
        <tr>
            <th>{{ __('TOTAL INFLOW') }}</th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th>{{ __('Total Inflow') }}</th>
            </th>
            <th></th>
            <th class="text-success">
                {!! config('basic.c_s') !!}{{ number_format($cash_sales->cash_total + $pos_sales->pos_total + $bank_sales->bank_total) }}
        </tr>
    </tbody>
</table>
