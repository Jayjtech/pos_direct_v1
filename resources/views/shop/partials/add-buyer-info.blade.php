<div class="modal-content">
    <form action="{{ route('add.buyer.info') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="modal-header">
            <h1 class="modal-title fs-5 font-weight-bold" id="editProductLabel">Add buyer's Information</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="">Buyer's name</label>
                <input type="text" class="form-control" maxlength="20" name="buyer"
                    value="{{ $pm_method->buyer }}" />
            </div>
            <input type="hidden" name="tab_id" value="{{ $pm_method->id }}">
            <div class="form-group">
                <label for="">Phone number</label>
                <input type="number" class="form-control" name="phone" value="{{ $pm_method->phone }}" />
            </div>

            <div class="form-group">
                <label for="">Buyer's address/delivery location</label>
                <textarea name="address" rows="4" class="form-control" placeholder="Buyer's address">{{ $pm_method->address }}</textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-success">Save buyer Info</button>
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </form>
</div>
