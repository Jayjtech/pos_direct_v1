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
                    <h1 class="font-weight-bold mb-2">USERS</h1>
                    <div class="table table-responsive mb-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="20%">Name</th>
                                    <th width="15%">Email</th>
                                    <th width="50%">Role(s)</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users_list as $list)
                                    <tr>
                                        <td>{{ $list->name }}</td>
                                        <td>{{ $list->email }}</td>
                                        <td>
                                            @foreach ($list->roles as $role)
                                                <p class="badge bg-light">{{ $role->name }}</p>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="edit-user">
                                                <a href="#{{ $list->id }}" class="btn btn-sm btn-secondary"
                                                    data-bs-toggle="modal" data-bs-target="#editUser"><i
                                                        class="typcn typcn-edit"></i></a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="delete-user">
                                                <a href="#{{ $list->name }}" data-id="{{ $list->id }}"
                                                    class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#deleteUser"> <i class="typcn typcn-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $users_list->links() !!}
                </div>
            </div>


            {{-- Edit Modal --}}
            <div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
                <div class="modal-dialog edit-modal"></div>
            </div>
            {{-- End --}}

            {{-- Delete Modal --}}
            <div class="modal fade" id="deleteUser" tabindex="-1" aria-labelledby="deleteUserLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 font-weight-bold" id="exampleModalLabel">Delete user</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body delete-modal"></div>
                        <div class="delete-modal-footer modal-footer"></div>
                    </div>
                </div>
            </div>
            {{-- End --}}
        @endsection

        @include('admin.js.user_js')
