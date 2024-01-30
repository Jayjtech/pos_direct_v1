@extends('guest.layouts.app')
@section('content')
    <div class="bg0 m-t-23 p-b-140">
        <div class="container">
            <div class="flex-w flex-sb-m p-b-52">
                <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                    @include('guest.partials.product_list')
                </div>
            </div>
        </div>
    </div>
@endsection
