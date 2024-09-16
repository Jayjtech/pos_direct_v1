@extends('layouts.user')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0 font-weight-bold">{{ Auth::user()->name }}</h3>
                    <p>{{ Auth::user()->email }}</p>
                </div>
            </div>

            @can('general-report')
                <h1 class="card-title font-weight-bold mt-5" style="font-size: 20px">General Sales</h1>
                <div class="row mt-3 mb-3">
                    <div class="col-sm-3 mb-3 mb-xl-0 pr-1">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Today's Sales</h4>
                                <p class="" style="font-size: 15px;"><i class="mdi mdi-wallet text-success"></i>
                                    {!! config('basic.c_s') !!}
                                    {{ number_format($allOrdersToday) }}
                                </p>
                                <small class="text-success font-weight-bold mt-3">Profit: {!! config('basic.c_s') !!}
                                    {{ number_format($sumToday->grand_total - $sumToday->grand_cost_price) }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 mb-3 mb-xl-0 pr-1">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Week's Sales</h4>
                                <p class="" style="font-size: 15px;"><i class="mdi mdi-wallet text-success"></i>
                                    {!! config('basic.c_s') !!}
                                    {{ number_format($allOrdersThisWeek) }}
                                </p>
                                <small class="text-success font-weight-bold mt-3">Profit: {!! config('basic.c_s') !!}
                                    {{ number_format($sumWeek->grand_total - $sumWeek->grand_cost_price) }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 mb-3 mb-xl-0 pr-1">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Month's Sales</h4>
                                <p class="" style="font-size: 15px;"><i class="mdi mdi-wallet text-success"></i>
                                    {!! config('basic.c_s') !!}
                                    {{ number_format($allOrdersThisMonth) }}
                                </p>
                                <small class="text-success font-weight-bold mt-3">Profit: {!! config('basic.c_s') !!}
                                    {{ number_format($sumMonth->grand_total - $sumMonth->grand_cost_price) }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 mb-3 mb-xl-0 pr-1">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Year's Sales</h4>
                                <p class="" style="font-size: 15px;"><i class="mdi mdi-wallet text-success"></i>
                                    {!! config('basic.c_s') !!}
                                    {{ number_format($allOrdersThisYear) }}
                                </p>
                                <small class="text-success font-weight-bold mt-3">Profit: {!! config('basic.c_s') !!}
                                    {{ number_format($sumYear->grand_total - $sumYear->grand_cost_price) }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan


            <h1 class="card-title font-weight-bold mt-5" style="font-size: 20px">My Sales</h1>
            <div class="row mt-3">
                <div class="col-sm-3 mb-3 mb-xl-0 pr-1">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3">Today's Sales</h4>
                            <p class="" style="font-size: 15px;"><i class="mdi mdi-wallet text-success"></i>
                                {!! config('basic.c_s') !!}
                                {{ number_format($myOrdersToday) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 mb-3 mb-xl-0 pr-1">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3">Week's Sales</h4>
                            <p class="" style="font-size: 15px;"><i class="mdi mdi-wallet text-success"></i>
                                {!! config('basic.c_s') !!}
                                {{ number_format($myOrdersThisWeek) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 mb-3 mb-xl-0 pr-1">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3">Month's Sales</h4>
                            <p class="" style="font-size: 15px;"><i class="mdi mdi-wallet text-success"></i>
                                {!! config('basic.c_s') !!}
                                {{ number_format($myOrdersThisMonth) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 mb-3 mb-xl-0 pr-1">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3">Year's Sales</h4>
                            <p class="" style="font-size: 15px;"><i class="mdi mdi-wallet text-success"></i>
                                {!! config('basic.c_s') !!}
                                {{ number_format($myOrdersThisYear) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>



            <!-- content-wrapper ends -->
        @endsection
