<div class="modal-content">
    <form action="{{ route('admin.add.role') }}" method="post">
        @csrf
        <div class="modal-header">
            <h1 class="modal-title fs-5 font-weight-bold" id="addNewRoleLabel">Create role</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="">Role name</label>
                <input type="text" class="form-control" name="name" placeholder="Role name" />
            </div>

            <div class="container" style="height: 300px; overflow-y:auto;">
                <p class="font-weight-bold">Permission(s)</p>

                @foreach ($permissions as $permission)
                    <div class="col-lg-12">
                        <div class="form-check">
                            <input class="form-check-input" name="permissions[]" type="checkbox"
                                value="{{ $permission->id }}" id="flexCheckDefault{{ $permission->id }}" unchecked>
                            <label class="form-check-label badge bg-light" for="flexCheckDefault{{ $permission->id }}">
                                {{ ucfirst($permission->name) }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Create role</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </form>
</div>
