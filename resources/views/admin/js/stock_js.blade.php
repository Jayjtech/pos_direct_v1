@push('script')
    <script>
        "use strict";
        // Make request
        $(document).ready(function() {
            $(document).on('click', '.make-request-stock a', function() {
                $.ajax({
                    url: "{{ route('admin.stock.request.view') }}",
                    type: "get",
                    success: function(response) {
                        $('.request-stock-modal').html(response.view)
                    }
                })
            })

            $(document).on('click', '.edit-request a', function() {
                var stock_id = $(this).attr("href").replace(new RegExp('#', 'g'), '');
                $.ajax({
                    url: "{{ route('admin.stock.edit.product.view') }}",
                    type: "get",
                    data: {
                        stock_id: stock_id
                    },
                    success: function(response) {
                        $('.request-edit-modal').html(response.view)
                    }
                })
            })

            // Add row
            $(document).on('click', '.modal-body #add', function() {
                $.ajax({
                    url: "{{ route('admin.stock.add.product.view') }}",
                    type: "get",
                    success: function(response) {
                        $('.dynamic-field').append(response.view)
                    }
                })
            })

            // Remove row
            $(document).on('click', '.remove-stock-row button', function() {
                var button_id = $(this).attr('data-id')
                $("#row_" + button_id).remove();
            })

            // Delete stock request
            $(document).on('click', '.delete-stock a', function() {
                var deleteStockRoute = "{{ route('admin.delete.stock', ':stock_id') }}";
                var name = $(this).attr("href").replace(new RegExp('#', 'g'), '');
                var stock_id = $(this).attr("data-id");
                var route = deleteStockRoute.replace(':stock_id', stock_id);

                $('.delete-modal-footer').html(
                    `<div class="d-flex justify-content-between w-100">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="confirmStockDelete">
                            <label class="form-check-label" for="confirmStockDelete">
                                I confirm this deletion
                            </label>
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                            <a href="${route}" class="btn btn-danger" id="confirmStockDeleteBtn" style="pointer-events: none; opacity: 0.5;">Delete Request</a>
                        </div>
                    </div>`
                );
                $('.delete-modal').html(
                    `<div class="alert alert-warning">
                        <h5><i class="fas fa-box"></i> Delete Stock Request</h5>
                        <p>You are about to delete the stock request for: <strong>${name}</strong></p>
                    </div>
                    <div class="alert alert-info">
                        <strong>What happens when you delete this request:</strong>
                        <ul class="mb-0 mt-2">
                            <li>The stock request will be permanently removed</li>
                            <li>You can only delete pending requests (not approved ones)</li>
                            <li>You can only delete your own requests unless you're an approver</li>
                            <li>This action cannot be undone</li>
                        </ul>
                    </div>
                    <div class="alert alert-secondary">
                        <strong>Note:</strong> Approved stock requests cannot be deleted to maintain audit trails.
                    </div>`
                );
                
                // Enable/disable delete button based on checkbox
                $('#confirmStockDelete').on('change', function() {
                    if ($(this).is(':checked')) {
                        $('#confirmStockDeleteBtn').css({'pointer-events': 'auto', 'opacity': '1'});
                    } else {
                        $('#confirmStockDeleteBtn').css({'pointer-events': 'none', 'opacity': '0.5'});
                    }
                });
            })
        })
    </script>
@endpush
