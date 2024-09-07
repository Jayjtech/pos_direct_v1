<div class="col-lg-7 mt-2">
    <div class="card">
        <div class="card-body">

            <div class="tab-display mb-2">
                {{-- Display saved tabs(carts) --}}
                @include('shop.partials.tab')
            </div>
            <div class="payment-method-container mb-2">
                @include('shop.partials.payment_methods')
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <p class="font-weight-bold mb-3" style="font-size: 3ex;">CART
                        <span class="badge badge-primary mb-3 mr-2 mb-xl-0 variety"><i class="mdi mdi-cart"></i> Variety:
                            {{ $active_cart->count() }}
                        </span>
                    </p>
                    <span id="response" class="mt-2" style="font-size: 10px;"></span>
                </div>
                <div class="col-lg-6">
                    <p class="font-weight-bold" id="grand-total">
                        Grand Total :
                        <span>{!! config('basic.c_s') !!}{{ $active_cart->count() ? number_format($active_cart[0]->cartReport->grand_total, 2) : 0 }}</span>
                    </p>
                </div>
            </div>

            <hr>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="25%" style="font-size:14px;">Product</th>
                            <th width="20%" style="font-size:14px;">Price</th>
                            <th width="25%" style="font-size:14px;">Qty</th>
                            <th width="20%" style="font-size:14px;">Dis
                                {{ companyInfo()->discount_mode == 1 ? '(%)' : 'Amt' }}</th>
                            <th width="10%" style="font-size:14px;">Total</th>
                        </tr>
                    </thead>
                </table>
                <div class="cart-display" style="height: 400px;overflow-y:auto;">
                    @include('shop.partials.cart_display')
                </div>
            </div>
        </div>
    </div>
</div>
