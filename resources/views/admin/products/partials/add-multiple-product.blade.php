<div class="modal-content">
    <p class="alert alert-info font-weight-bold">Note that different files must be uploaded for different categories.</p>
    <form action="{{ route('admin.import.products') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="modal-header">
            <h1 class="modal-title fs-5 font-weight-bold" id="editProductLabel">Add product</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-group mb-3">
                <label for="">Choose file</label><br>
                <input type="file" name="csv_file" class="btn btn-sm btn-primary mt-3" accept=".csv">
            </div>

            <div class="form-group">
                <select name="category_id" class="form-control" required>
                    <option value="">Choose category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-success">Upload</button>
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </form>
</div>
