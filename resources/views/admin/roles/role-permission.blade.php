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
                    <div class="d-flex align-items-center justify-content-md-end add-role">
                        <a href="" class="btn btn-sm btn-success" data-bs-toggle="modal"
                            data-bs-target="#addNewRole"><i class="typcn typcn-plus"></i> Create New Role</a>
                    </div>
                    <h1 class="font-weight-bold mb-2">ROLES AND PERMISSIONS</h1>
                    <div class="table table-responsive mb-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="30%">Role</th>
                                    <th width="50%">Permissions</th>
                                    <th width="10%" colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td class="font-weight-bold">{{ strtoupper($role->name) }}</td>
                                        <td>
                                            @php
                                                $n = 1;
                                            @endphp
                                            @forelse ($role->permissions as $permission)
                                                <p class="badge bg-light mr-2 ml-2 mb-2">{{ $n }}.
                                                    {{ strtoupper($permission->name) }}</p>
                                                @php
                                                    $n++;
                                                @endphp
                                            @empty
                                                <p class="alert alert-danger">Role has no permissions yet!</p>
                                            @endforelse
                                        </td>
                                        <td>
                                            <div class="edit-role">
                                                <a href="#{{ $role->id }}" class="btn btn-sm btn-secondary"
                                                    data-bs-toggle="modal" data-bs-target="#editRole"> <i
                                                        class="typcn typcn-pen"></i></a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="delete-role">
                                                <a href="#{{ $role->name }}" data-id="{{ $role->id }}"
                                                    class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#deleteRole"> <i class="typcn typcn-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $roles->links() !!}
                </div>
            </div>


            {{-- Edit Modal --}}
            <div class="modal fade" id="editRole" tabindex="-1" aria-labelledby="editRoleLabel" aria-hidden="true">
                <div class="modal-dialog edit-modal"></div>
            </div>
            {{-- End --}}

            {{-- Add Modal --}}
            <div class="modal fade" id="addNewRole" tabindex="-1" aria-labelledby="addNewRoleLabel" aria-hidden="true">
                <div class="modal-dialog add-modal"></div>
            </div>
            {{-- End --}}

            {{-- Delete Modal --}}
            <div class="modal fade" id="deleteRole" tabindex="-1" aria-labelledby="deleteRoleLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 font-weight-bold" id="exampleModalLabel">Delete role</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body delete-modal"></div>
                        <div class="delete-modal-footer modal-footer"></div>
                    </div>
                </div>
            </div>
            {{-- End --}}
        @endsection

        @include('admin.js.role_js')
