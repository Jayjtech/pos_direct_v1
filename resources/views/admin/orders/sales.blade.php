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
                <div class="col-sm-6">
                    <form action="{{ route('admin.search.sales') }}" method="get">
                        <div class="d-flex align-items-center justify-content-md-end">
                            <div class="mb-3 mb-xl-0 pr-1">
                                <div class="dropdown">
                                    <div class="form-group"><label for="startDate">Start Date:</label>
                                        <input type="date" id="startDate" value="{{ $startDate }}"
                                            class="form-control" name="startDate" required>
                                    </div>
                                </div>
                            </div>
                            <div class="pr-1 mb-3 mr-2 mb-xl-0">
                                <div class="form-group"><label for="endDate">End Date:</label>
                                    <input type="date" id="endDate" value="{{ $endDate }}" class="form-control"
                                        name="endDate" required>
                                </div>
                            </div>
                            <div class="pr-1 mb-3 mb-xl-0">
                                <button type="submit" id="btn" class="btn btn-light">
                                    Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- Start of edit-user --}}
            <div class="card mt-3">
                <div class="card-body">
                    <h1 class="font-weight-bold mb-2">SALES REPORTS</h1>
                    <div class="d-flex align-items-center justify-content-md-end get-pdf">

                        <a href="{{ route('admin.sales.pdf', ['startDate' => $startDate, 'endDate' => $endDate]) }}"
                            class="btn btn-sm btn-danger"><i class="mdi mdi-file-pdf"></i>PDF</a>
                    </div>
                    <div class="table table-responsive mb-3 display-sales">
                        <p class="mb-2 font-weight-bold text-success">GRAND TOTAL:
                            {!! config('basic.c_s') !!}{{ number_format($grand_total, 2) }}</p>
                        @include('admin.orders.partials.sales-table')
                        {!! $products->links() !!}
                    </div>
                </div>
            </div>
        @endsection
