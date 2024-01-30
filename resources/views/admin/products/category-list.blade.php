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
                    <h1 class="font-weight-bold mb-2">CATEGORIES</h1>
                    <div class="d-flex align-items-center justify-content-md-end add-category">
                        <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                            data-bs-target="#addCategory"><i class="typcn typcn-plus"></i> Add Category</a>
                    </div>
                    <div class="table table-responsive mb-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="">S/N</th>
                                    <th width="">Category</th>
                                    <th width="">Status</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $n = 0;
                                @endphp
                                @foreach ($categories as $category)
                                    @php
                                        $n++;
                                    @endphp
                                    <tr>
                                        <td>{{ $n }}</td>
                                        <td>{{ $category->title }}</td>
                                        <td>
                                            <p
                                                class="badge @if ($category->status == 1) bg-success @else bg-danger @endif">
                                                @if ($category->status == 1)
                                                    Available
                                                @else
                                                    Unavailable
                                                @endif
                                            </p>
                                        </td>

                                        <td>
                                            <div class="edit-category">
                                                <a href="#{{ $category->id }}" class="btn btn-sm btn-secondary"
                                                    data-bs-toggle="modal" data-bs-target="#editCategory"><i
                                                        class="typcn typcn-edit"></i></a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="delete-category">
                                                <a href="#{{ $category->name }}" data-id="{{ $category->id }}"
                                                    class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#deleteCategory"> <i class="typcn typcn-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $categories->links() !!}
                </div>
            </div>


            {{-- Edit Modal --}}
            <div class="modal fade" id="editCategory" tabindex="-1" aria-labelledby="editCategoryLabel" aria-hidden="true">
                <div class="modal-dialog edit-modal"></div>
            </div>

            {{-- Add Modal --}}
            <div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
                <div class="modal-dialog add-modal"></div>
            </div>
            {{-- End --}}

            {{-- Delete Modal --}}
            <div class="modal fade" id="deleteCategory" tabindex="-1" aria-labelledby="deleteCategoryLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 font-weight-bold" id="exampleModalLabel">Delete category</h1>
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
