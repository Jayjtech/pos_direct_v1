@extends('layouts.user')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0 font-weight-bold">{{ Auth::user()->name }}</h3>
                    <p>{{ Auth::user()->email }}</p>
                </div>
                <div class="col-sm-6">
                    <form action="{{ route('admin.search.order') }}" method="get">
                        <div class="d-flex align-items-center justify-content-md-end">
                            <div class="mb-3 mb-xl-0 pr-1">
                                <div class="dropdown">
                                    <div class="form-group"><label for="startDate">Start Date:</label>
                                        <input type="date" id="startDate" class="form-control"
                                            value="{{ $startDate }}" name="startDate" required>
                                    </div>
                                </div>
                            </div>
                            <div class="pr-1 mb-3 mr-2 mb-xl-0">
                                <div class="form-group"><label for="endDate">End Date:</label>
                                    <input type="date" id="endDate" class="form-control" value="{{ $endDate }}"
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
                    <h1 class="font-weight-bold mb-2">INVOICES</h1>
                    <div class="d-flex align-items-center justify-content-md-end get-pdf">
                        <div class="mb-3 mb-xl-0 pr-1">
                            <a href="{{ route('admin.order.pdf', ['startDate' => $startDate, 'endDate' => $endDate]) }}"
                                class="btn btn-sm btn-danger"><i class="mdi mdi-file-pdf"></i>PDF</a>
                        </div>

                        <div class="mb-3 mb-xl-0 pr-1">
                            <a href="{{ route('admin.export.orders', ['startDate' => $startDate, 'endDate' => $endDate]) }}"
                                class="btn btn-sm btn-success"><i class="mdi mdi-file"></i>Excel</a>
                        </div>
                    </div>

                    <div class="table table-responsive mb-3 display-order">
                        <p class="mb-2 font-weight-bold text-success">GRAND TOTAL:
                            {!! config('basic.c_s') !!}{{ number_format($grand_total, 2) }}</p>
                        @include('admin.orders.partials.order-table')
                    </div>
                    {!! $combined_orders->links() !!}
                </div>
            </div>

            {{-- Edit Modal --}}
            <div class="modal fade" id="refundOrder" tabindex="-1" aria-labelledby="refundOrderLabel" aria-hidden="true">
                <div class="modal-dialog refund-modal"></div>
            </div>
            {{-- End --}}
        @endsection

        @include('admin.js.order_js')
