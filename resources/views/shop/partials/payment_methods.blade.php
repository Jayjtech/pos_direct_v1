<div class="row">
    <div class="col-lg-6">
        @if ($active_cart_id != 0)
            <p class="font-weight-bold">{{ __("Buyer's name:") }}</p>
            <input type="text" class="form-control cart-buyer-name" placeholder="Enter buyer's name"
                value="{{ $pm_method->buyer }}">
        @endif
    </div>
    <div class="col-lg-6">
        @if ($active_cart_id != 0)
            <p class="font-weight-bold mb-2" style="font-size: 2ex;">{{ __('CHECKOUT METHOD') }}</p>
            <div class="d-flex checkout-methods">
                <div class="mb-3 mb-xl-0 pr-1">
                    <div class="dropdown">
                        <button type="button"
                            class="btn btn-sm @if ($pm_method->payment_method == 1) btn-primary @else bg-white @endif btn-icon-text border"
                            style="font-size: 9px;" data-cart-report-id="{{ $active_cart_id }}" data-id="1"><i
                                class="typcn typcn-cash mr-2"></i>{{ __('CASH') }}</button>
                    </div>
                </div>
                <div class="mb-3 mb-xl-0 pr-1">
                    <div class="dropdown">
                        <button type="button"
                            class="btn btn-sm @if ($pm_method->payment_method == 2) btn-primary @else bg-white @endif btn-icon-text border"
                            style="font-size: 9px;" data-cart-report-id="{{ $active_cart_id }}" data-id="2"><i
                                class="typcn typcn-credit-card mr-2"></i>{{ __('CREDIT CARD') }}</button>
                    </div>
                </div>
                <div class="mb-3 mb-xl-0 pr-1">
                    <div class="dropdown">
                        <button type="button"
                            class="btn btn-sm @if ($pm_method->payment_method == 3) btn-primary @else bg-white @endif btn-icon-text border"
                            style="font-size: 9px;" data-cart-report-id="{{ $active_cart_id }}" data-id="3"><i
                                class="typcn typcn-account-balance mr-2"></i>{{ __('BANK TRANSFER') }}</button>
                    </div>
                </div>
                <div class="mb-3 mb-xl-0 pr-1">
                    <div class="dropdown">
                        <button type="button"
                            class="btn btn-sm @if ($pm_method->payment_method == 4) btn-primary @else bg-white @endif btn-icon-text border"
                            style="font-size: 9px;" data-cart-report-id="{{ $active_cart_id }}" data-id="4"><i
                                class="typcn typcn-account-balance mr-2"></i>{{ __('CREDIT SALES') }}</button>
                    </div>
                </div>
                <input type="hidden" id="checkoutMethod" value="{{ $pm_method->payment_method }}">
            </div>
        @endif
    </div>

</div>
@if ($active_cart_id != 0)
    {{-- Add Modal --}}
    <div class="modal fade" id="addBuyerInfo" tabindex="-1" aria-labelledby="addBuyerInfoLabel" aria-hidden="true">
        <div class="modal-dialog add-modal">
            @include('shop.partials.add-buyer-info')
        </div>
    </div>
@endif
{{-- End --}}
