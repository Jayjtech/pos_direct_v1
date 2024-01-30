@extends('guest.layouts.home')
@section('content')
    {{-- SLIDER --}}
    @include('guest.partials.slider')
    {{-- BANNER --}}
    @include('guest.partials.banner')
    {{-- PRODUCTS --}}
    @include('guest.partials.products')
@endsection
