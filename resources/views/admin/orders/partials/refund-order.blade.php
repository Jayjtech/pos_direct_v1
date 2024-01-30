<div class="modal-content">
    <form action="{{ route('admin.refund.order') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="modal-header">
            <h1 class="modal-title fs-5 font-weight-bold" id="editProductLabel">Refund order <span class="ml-5">Date:
                    {{ dateFormatter($sub->created_at) }}</span></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <input type="hidden" name="combined_order_id" value="{{ $sub->id }}">
        <div class="modal-body">
            {{-- SubOrder table --}}
            <td>
                <div class="table-responsive" style="font-size: 8px;">
                    <div class="">
                        <a href="#" class="btn btn-sm btn-secondary" id="checkAll">Check all</a>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="font-size: 11px;">Product</th>
                                <th style="font-size: 11px;">Price</th>
                                <th style="font-size: 11px;">Qty</th>
                                <th style="font-size: 11px;">Dis(%)</th>
                                <th style="font-size: 11px;">Sub total</th>
                                <th style="font-size: 11px;"></th>
                            </tr>
                        </thead>
                        @php
                            $buyer_details = json_decode($sub->buyer_details);
                            $split_name = explode(' ', $sub->user->name);
                            $attendant = end($split_name);
                        @endphp

                        <tbody>
                            @foreach ($sub->orders as $prod)
                                <tr class="@if ($prod->status == 2) bg-info text-light @endif">
                                    <td>
                                        @if ($prod->status != 2)
                                            <input type="checkbox" name="orders[]" class="form-control p-4"
                                                value="{{ $prod->id }}">
                                        @endif
                                    </td>
                                    <td style="font-size: 11px;" class="font-weight-bold">{{ $prod->product }}</td>
                                    <td style="font-size: 11px;">
                                        {!! config('basic.c_s') !!}{{ number_format($prod->unit_price, 2) }}
                                    </td>
                                    <td style="font-size: 11px;">{{ $prod->qty }}</td>
                                    <td style="font-size: 11px;">{{ $prod->discount }}</td>
                                    <td style="font-size: 11px;">
                                        {!! config('basic.c_s') !!}{{ number_format($prod->sub_total, 2) }}
                                    </td>
                                    <td style="font-size: 11px;">
                                        @if ($prod->status == 2)
                                            <span>Refunded</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td style="font-size: 11px;" colspan="5" class="font-weight-bold">Grand Total</td>
                                <td style="font-size: 11px;" class="font-weight-bold">
                                    {!! config('basic.c_s') !!}{{ number_format($sub->grand_total, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11px;" colspan="5">Checkout Method</td>
                                <td style="font-size: 11px;" class="font-weight-bold">
                                    {{ strtoupper($buyer_details->payment_method) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </td>
            {{-- End of SubOrder table --}}
        </div>

        <div class="modal-footer">
            <p>Are you sure you want to make a refund?</p>
            <button type="submit" class="btn btn-sm btn-danger">Yes</button>
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">No</button>
        </div>
    </form>
</div>
