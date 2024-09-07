<div class="modal-content">
    <form action="{{ route('admin.save.stock.request.changes') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="modal-header">
            <h1 class="modal-title fs-5 font-weight-bold" id="editProductLabel">{{ __('Edit') }} {{ $stock->product }}
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="form-group">
                <label for="">Stock</label>
                <input type="text" name="product" class="form-control" readonly value="{{ $stock->product }}">
                <input type="hidden" name="stock_id" value="{{ $stock->id }}">
            </div>
            <div class="form-group">
                <label for="">Quantity</label>
                <input type="number" name="quantity" value="{{ $stock->qty_requested }}" class="form-control"
                    placeholder="Quantity" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </form>
</div>
