@extends('layouts.user')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="card mt-3">
                <div class="card-body">
                    <h1 class="font-weight-bold mb-2">SUBSCRIPTION</h1>
                    <div class="alert-el"></div>
                    <div class="table table-responsive mb-3 display-plan">

                    </div>
                    <div class="d-flex align-items-center justify-content-md-end ">
                        <p class="renewal-price mr-4"></p>
                        <button id="renewal-btn" style="display: none;" class="btn btn-primary"
                            onclick="payWithMonnify()">Renew now</button>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.js.activation_js')
    @endsection
