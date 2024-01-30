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
            {{-- Start of edit-user --}}
            <div class="card mt-3">
                <div class="card-body">
                    <h1 class="font-weight-bold mb-2">STOCK REQUESTS</h1>
                    <div class="d-flex align-items-center justify-content-md-end make-request-stock">
                        <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                            data-bs-target="#makeRequest"><i class="typcn typcn-clipboard"></i> Make request</a>
                    </div>
                    <div class="table table-responsive mb-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="10%">Image</th>
                                    <th width="20%">Product</th>
                                    @can('response')
                                        <th width="15%">User</th>
                                    @endcan
                                    <th width="15%">Store before</th>
                                    <th width="20%">Qty requested</th>
                                    <th width="15%">Store after</th>
                                    <th width="20%">Date</th>
                                    <th width="10%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stocks as $stock)
                                    <tr>
                                        <td>
                                            @if ($stock->products->img)
                                                <img src="{{ asset('uploads/' . $stock->products->img) }}"
                                                    alt="{{ $stock->product }}">
                                            @else
                                                <img src="{{ asset('ui/images/default.png') }}" alt="{{ $stock->product }}">
                                            @endif
                                        </td>
                                        <td>{{ $stock->product }}</td>
                                        <td>{{ $stock->qty_before_approval }}</td>
                                        <td>{{ $stock->qty_requested }}</td>
                                        <td>{{ $stock->qty_after_approval }}</td>
                                        <td>{{ dateFormatter($stock->updated_at) }}</td>
                                        <td>
                                            <span class="badge bg-{{ getStatus($stock->status)->color }}">
                                                {{ getStatus($stock->status)->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $stocks->links() !!}
                </div>
            </div>

            {{-- Add Modal --}}
            <div class="modal fade" id="makeRequest" tabindex="-1" aria-labelledby="makeRequestLabel" aria-hidden="true">
                <div class="modal-dialog request-stock-modal"></div>
            </div>
            {{-- End --}}

            {{-- Add Modal --}}
            <div class="modal fade" id="editRequest" tabindex="-1" aria-labelledby="editRequestLabel" aria-hidden="true">
                <div class="modal-dialog request-edit-modal"></div>
            </div>
            {{-- End --}}

            {{-- Delete Modal --}}
            <div class="modal fade" id="deleteStock" tabindex="-1" aria-labelledby="deleteStockLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 font-weight-bold" id="exampleModalLabel">Delete product</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                X
                            </button>
                        </div>
                        <div class="modal-body delete-modal"></div>
                        <div class="delete-modal-footer modal-footer"></div>
                    </div>
                </div>
            </div>
            {{-- End --}}
        @endsection

        @include('admin.js.stock_js')
