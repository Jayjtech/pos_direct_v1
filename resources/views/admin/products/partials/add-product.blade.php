<div class="modal-content">
    <form action="{{ route('admin.add.product') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="modal-header">
            <h1 class="modal-title fs-5 font-weight-bold" id="editProductLabel">Add product</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-4">
                    <img src="{{ asset('ui/images/default.png') }}" class="img-thumbnail" id="pdtPreview"
                        width="200">
                </div>
                <div class="col-8">
                    <input type="file" name="pdt_img" id="pdtImg" onchange="previewPdt();"
                        class="btn btn-sm btn-primary mt-3" accept=".jpg,.png">
                </div>
            </div>

            <div class="form-group">
                <label for="">Product name</label>
                <input type="text" class="form-control" placeholder="Product name" name="name" required />
            </div>

            <div class="form-group">
                <label for="">Product Code</label>
                <input type="text" class="form-control" placeholder="Product code" name="product_code" />
            </div>

            <div class="form-group">
                <label for="">Price</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-primary text-white">{!! config('basic.c_s') !!}</span>
                    </div>
                    <input type="number" class="form-control" name="price" placeholder="Price" required />
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-6">
                    <label for="">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="1">Available</option>
                        <option value="0">Unavailable</option>
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label for="">Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Choose category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-success">Add product</button>
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </form>
</div>
