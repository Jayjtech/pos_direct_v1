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
                        <a href="{{ route('admin.approve.all.stock') }}" class="btn btn-sm btn-success"><i
                                class="mdi mdi-checkbox-marked-circle-outline"></i> Approve all
                            requests</a>
                    </div>
                    <form action="{{ route('admin.approve.checked.stock') }}" method="post">
                        <div class="form-group">
                            <button type="submit"
                                class="btn btn-sm btn-light">{{ __('Approve Checked Requests') }}</button>
                        </div>
                        <div class="table table-responsive mb-3">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="">#</th>
                                        <th width="10%">Image</th>
                                        <th width="20%">Product</th>
                                        <th width="10%">Quantity</th>
                                        <th width="20%">Barcode</th>
                                        <th width="20%">Date</th>
                                        <th width="10%">Status</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @csrf
                                    @foreach ($stocks as $stock)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="stocks[]" class="form-control"
                                                    value="{{ $stock->id }}">
                                            </td>
                                            <td>
                                                @if ($stock->products->img)
                                                    <img src="{{ asset('uploads/' . $stock->products->img) }}"
                                                        alt="{{ $stock->product }}">
                                                @else
                                                    <img src="{{ asset('ui/images/default.png') }}"
                                                        alt="{{ $stock->product }}">
                                                @endif
                                            </td>
                                            <td>{{ $stock->product }}</td>
                                            <td>{{ $stock->qty_requested }}</td>
                                            <td>
                                                @if ($stock->product_code)
                                                    {!! DNS1D::getBarcodeHTML($stock->product_code, 'CODABAR', 2, 30) !!}
                                                    <p class="text-center font-weight-bold">{{ $stock->product_code }}</p>
                                                @endif
                                            </td>
                                            <td>{{ dateFormatter($stock->updated_at) }}</td>
                                            <td>
                                                <p
                                                    class="badge @if ($stock->status == 1) bg-success @else bg-warning @endif">
                                                    @if ($stock->status == 1)
                                                        Successful
                                                    @else
                                                        Pending
                                                    @endif
                                                </p>
                                            </td>

                                            <td>
                                                <div class="approve-request">
                                                    <a href="#{{ $stock->id }}" class="btn btn-sm btn-success"
                                                        data-bs-toggle="modal" data-bs-target="#approveRequest"><i
                                                            class="mdi mdi-checkbox-marked-circle-outline"></i></a>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="delete-stock">
                                                    <a href="#{{ $stock->product }}" data-id="{{ $stock->id }}"
                                                        class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#deleteStock"> <i class="typcn typcn-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
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
