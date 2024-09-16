@extends('layouts.pdf')
@section('content')
    <div class="table table-responsive">
        <table class="table table-hover">
            <tbody>
                {{-- Cash flow --}}
                <tr>
                    <th width="50%">{{ __('CASH INFLOW') }}</th>
                    <th width="25%"></th>
                    <th width="25%"></th>
                </tr>
                <tr>
                    <th width="50%">{{ __('Cash Sales') }}</th>
                    <th width="25%">{{ config('basic.currency') }}{{ number_format($cash_sales->cash_total) }}</th>
                    <th width="25%"></th>
                </tr>
                <tr>
                    <th width="50%">{{ __('TOTAL CASH INFLOW') }}</th>
                    <th width="25%"></th>
                    <th width="25%">{{ config('basic.currency') }}{{ number_format($cash_sales->cash_total) }}</th>
                </tr>

                {{-- POS INFLOW --}}
                <tr>
                    <th width="50%">{{ __('POS INFLOW') }}</th>
                    <th width="25%"></th>
                    <th width="25%"></th>
                </tr>

                <tr>
                    <th width="50%">{{ __('POS Sales') }}</th>
                    <th width="25%">{{ config('basic.currency') }}{{ number_format($pos_sales->pos_total) }}</th>
                    <th width="25%"></th>
                </tr>
                <tr>
                    <th width="50%">{{ __('TOTAL POS INFLOW') }}</th>
                    <th width="25%"></th>
                    <th width="25%">{{ config('basic.currency') }}{{ number_format($pos_sales->pos_total) }}</th>
                </tr>

                {{-- BANK TRANSFER INFLOW --}}
                <tr>
                    <th width="50%">{{ __('BANK INFLOW') }}</th>
                    <th width="25%"></th>
                    <th width="25%"></th>
                </tr>
                <tr>
                    <th width="50%">{{ __('Bank Transfer Sales') }}</th>
                    <th width="25%">{{ config('basic.currency') }}{{ number_format($bank_sales->bank_total) }}</th>
                    <th width="25%"></th>
                </tr>
                <tr>
                    <th width="50%">{{ __('TOTAL BANK INFLOW') }}</th>
                    <th width="25%"></th>
                    <th width="25%">{{ config('basic.currency') }}{{ number_format($bank_sales->bank_total) }}</th>
                </tr>

                {{-- TOTAL INFLOW --}}
                <tr>
                    <th width="50%">{{ __('TOTAL INFLOW') }}</th>
                    <th width="25%"></th>
                    <th width="25%"></th>
                </tr>
                <tr>
                    <th width="50%">{{ __('Total Inflow') }}</th>
                    <th width="25%"></th>
                    <th width="25%" class="text-success">
                        {{ config('basic.currency') }}{{ number_format($cash_sales->cash_total + $pos_sales->pos_total + $bank_sales->bank_total) }}
                    </th>
                </tr>
                {{-- DISCOUNT --}}
                <tr>
                    <th width="50%">{{ __('DISCOUNT') }}</th>
                    <th width="25%"></th>
                    <th width="25%"></th>
                </tr>
                <tr>
                    <th width="50%">{{ __('Total Discount') }}</th>
                    <th width="25%" class="text-danger">
                        {{ config('basic.currency') }}{{ number_format($total_discount) }}</th>
                    <th width="25%"></th>
                </tr>
            </tbody>
        </table>

    </div>
@endsection
