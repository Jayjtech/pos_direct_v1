<div class="modal-content">
    <form action="{{ route('admin.save.role.changes') }}" method="post">
        @csrf
        <div class="modal-header">
            <h1 class="modal-title fs-5 font-weight-bold" id="editRoleLabel">Edit {{ $role->name }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <div class="form-group">
                <label for="">Role name</label>
                <input type="text" class="form-control" name="name" value="{{ $role->name }}"
                    placeholder="Role name" />
            </div>
            <input type="hidden" name="role_id" value="{{ $role->id }}">

            <div class="container" style="height: 300px; overflow-y:auto;">
                <p class="font-weight-bold">Permission(s)</p>
                @foreach ($permissions as $permission)
                    <div class="col-lg-12">
                        <div class="form-check">
                            <input class="form-check-input" name="permissions[]" type="checkbox"
                                value="{{ $permission->id }}" id="flexCheckDefault{{ $permission->id }}"
                                {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheckDefault{{ $permission->id }}">
                                {{ ucfirst($permission->name) }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </form>
</div>
