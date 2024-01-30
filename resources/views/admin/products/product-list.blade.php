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
                    <div class="d-flex align-items-center justify-content-md-end">
                        <div class="pr-1 mb-3 mr-2 mb-xl-0">
                            <a href="{{ route('admin.export.products') }}" class="btn btn-sm bg-white btn-icon-text border"><i
                                    class="typcn typcn-arrow-forward-outline mr-2"></i>Export csv file</a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Start of edit-user --}}
            <div class="card mt-3">
                <div class="card-body">
                    <h1 class="font-weight-bold mb-2">PRODUCTS</h1>
                    <div class="d-flex align-items-center justify-content-md-end">
                        <div class="pr-1 mb-3 mr-2 mb-xl-0 add-product">
                            <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                data-bs-target="#addProduct"><i class="typcn typcn-plus"></i> Add Product</a>
                        </div>

                        <div class="pr-1 mb-3 mr-2 mb-xl-0 add-multiple-product">
                            <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                data-bs-target="#addMultipleProducts"><i class="typcn typcn-plus"></i> Add Multiple
                                Products</a>
                        </div>
                    </div>
                    <div class="table table-responsive mb-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="10%">Image</th>
                                    <th width="30%">Product</th>
                                    <th width="20%">Category</th>
                                    <th width="15%">Price</th>
                                    <th width="10%">In Store</th>
                                    <th width="30%">Barcode</th>
                                    <th width="10%">Status</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            @if ($product->img)
                                                <img src="{{ asset('uploads/' . $product->img) }}"
                                                    alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('ui/images/default.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->category->title }}</td>
                                        <td>{!! config('basic.c_s') !!}{{ number_format($product->price, 2) }}</td>
                                        <td>{{ number_format($product->availability) }}</td>
                                        <td>
                                            @if ($product->product_code)
                                                {!! DNS1D::getBarcodeHTML($product->product_code, 'CODABAR', 2, 30) !!}
                                                <p class="text-center font-weight-bold">{{ $product->product_code }}</p>
                                            @endif
                                        </td>
                                        <td>
                                            <p
                                                class="badge @if ($product->status == 1) bg-success @else bg-danger @endif">
                                                @if ($product->status == 1)
                                                    Available
                                                @else
                                                    Unavailable
                                                @endif
                                            </p>
                                        </td>

                                        <td>
                                            <div class="edit-product">
                                                <a href="#{{ $product->id }}" class="btn btn-sm btn-secondary"
                                                    data-bs-toggle="modal" data-bs-target="#editProduct"><i
                                                        class="typcn typcn-edit"></i></a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="delete-product">
                                                <a href="#{{ $product->name }}" data-id="{{ $product->id }}"
                                                    class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#deleteProduct"> <i class="typcn typcn-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $products->links() !!}
                </div>
            </div>


            {{-- Edit Modal --}}
            <div class="modal fade" id="editProduct" tabindex="-1" aria-labelledby="editProductLabel" aria-hidden="true">
                <div class="modal-dialog edit-modal"></div>
            </div>

            {{-- Add Modal --}}
            <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
                <div class="modal-dialog add-modal"></div>
            </div>
            {{-- End --}}

            {{-- Add Modal --}}
            <div class="modal fade" id="addMultipleProducts" tabindex="-1" aria-labelledby="addMultipleProductsLabel"
                aria-hidden="true">
                <div class="modal-dialog add-modal"></div>
            </div>
            {{-- End --}}

            {{-- Delete Modal --}}
            <div class="modal fade" id="deleteProduct" tabindex="-1" aria-labelledby="deleteProductLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 font-weight-bold" id="exampleModalLabel">Delete product</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body delete-modal"></div>
                        <div class="delete-modal-footer modal-footer"></div>
                    </div>
                </div>
            </div>
            {{-- End --}}
        @endsection

        @include('admin.js.product_js')
