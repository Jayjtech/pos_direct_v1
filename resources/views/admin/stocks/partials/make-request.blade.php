<div class="modal-content">
    <form action="{{ route('admin.send.stock.request') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="modal-header">
            <h1 class="modal-title fs-5 font-weight-bold" id="editProductLabel">Stock Request Form</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body dynamic-field">
            <div class="table table-responsive">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>
                                <select name="product_ids[]" class="form-control" required>
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input type="number" name="quantities[]" class="form-control" placeholder="Quantity"
                                    required>
                            </td>

                            <td>
                                <button type="button" name="add" id="add" class="btn btn-success"><i
                                        class="typcn typcn-plus"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-success">Send request</button>
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </form>
</div>
