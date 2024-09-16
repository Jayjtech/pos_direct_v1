<div class="table table-responsive" id="row_{{ $row_id }}">
    <table class="table table-striped">
        <tbody>
            <tr>
                <td>
                    <select name="product_ids[]" class="form-control" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}
                                ({{ number_format($product->availability) }})
                            </option>
                        @endforeach
                    </select>
                </td>

                <td>
                    <input type="number" name="quantities[]" required class="form-control" placeholder="Quantity">
                </td>

                <td>
                    <div class="remove-stock-row">
                        <button type="button" data-id="{{ $row_id }}" class="btn btn-danger"><i
                                class="typcn typcn-trash"></i></button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
