<div class="modal-content">
    <form action="{{ route('admin.save.user.changes') }}" method="post">
        @csrf
        <div class="modal-header">
            <h1 class="modal-title fs-5 font-weight-bold" id="editUserLabel">Edit {{ $user->name }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <div class="form-group">
                <label for="">Name</label>
                <input type="text" class="form-control" name="name" value="{{ $user->name }}" />
            </div>
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" class="form-control" name="email" value="{{ $user->email }}" />
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" class="form-control" name="password" id="password" />
            </div>
            <div class="container">
                <p class="font-weight-bold">Role(s)</p>
                @foreach ($roles as $role)
                    <div class="col-lg-4">
                        <div class="form-check">
                            <input class="form-check-input" name="roles[]" type="checkbox" value="{{ $role->id }}"
                                id="flexCheckDefault{{ $role->id }}"
                                {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheckDefault{{ $role->id }}">
                                {{ ucfirst($role->name) }}
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
