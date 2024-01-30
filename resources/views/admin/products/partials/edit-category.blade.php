<div class="modal-content">
    <form action="{{ route('admin.save.category.changes') }}" method="post">
        @csrf
        <div class="modal-header">
            <h1 class="modal-title fs-5 font-weight-bold" id="editProductLabel">Edit {{ $category->title }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="">Category</label>
                <input type="text" class="form-control" name="title" value="{{ $category->title }}" />
            </div>
            <input type="hidden" name="category_id" value="{{ $category->id }}">

            <div class="form-group">
                <label for="">Status</label>
                <select name="status" class="form-control">
                    <option value="{{ $category->status }}">
                        @if ($category->status == 1)
                            Available
                        @else
                            Unavailable
                        @endif
                    </option>
                    <option
                        value="
                        @if ($category->status == 1) 0
                        @else
                            1 @endif
                            ">
                        @if ($category->status == 1)
                            Unavailable
                        @else
                            Available
                        @endif
                    </option>
                </select>
            </div>


        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </form>
</div>
