@extends('layouts.shop')
@section('content')
    <!-- partial -->
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-8">
                <h3 class="mb-0 font-weight-bold">{{ Auth::user()->name }}</h3>
                <p>{{ Auth::user()->email }}</p>
            </div>
            <div class="col-lg-4">
                <div class="d-flex align-items-center justify-content-md-end">
                    <div class="mb-3 mb-xl-0 pr-1">
                        <div class="">
                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary" style="font-size:11px;"><i
                                    class="typcn typcn-device-desktop menu-icon" style="font-size:11px;"></i> Dashboard</a>
                        </div>
                    </div>
                    <div class="pr-1 mb-3 mr-2 mb-xl-0">
                        <button type="button" class="btn btn-sm btn-success new-tab"
                            active-tab="{{ $active_cart->count() ? $active_cart[0]->cartReport->id : null }}"><i
                                style="font-size:11px;" class="mdi mdi-content-save"> Invoice / New
                                Tab</i> </button>
                    </div>

                    @can('generate-receipt')
                        <div class="pr-1 mb-3 mr-2 mb-xl-0">
                            <input type="text" class="form-control get-invoice" placeholder="Enter Invoice ID">
                        </div>
                    @endcan
                </div>
            </div>

            {{-- PRODUCTS DISPLAY --}}
            @include('shop.partials.product_display')

            {{-- CART --}}
            @include('shop.partials.cart')
        </div>

    </div>
@endsection

@include('shop.js.shop_js')
@include('shop.js.cart_js')
