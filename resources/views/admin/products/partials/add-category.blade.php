<div class="modal-content">
    <form action="{{ route('admin.add.category') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="modal-header">
            <h1 class="modal-title fs-5 font-weight-bold" id="editProductLabel">Add product</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="form-group">
                <label for="">Category title</label>
                <input type="text" class="form-control" name="title" placeholder="Category title" />
            </div>

            <div class="form-group">
                <label for="">Status</label>
                <select name="status" class="form-control">
                    <option value="1">Available</option>
                    <option value="0">Unavailable</option>
                </select>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-success">Add product</button>
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </form>
</div>
