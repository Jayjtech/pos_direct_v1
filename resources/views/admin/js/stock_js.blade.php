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

            // Delete user
            $(document).on('click', '.delete-stock a', function() {
                var name = $(this).attr("href").replace(new RegExp('#', 'g'), '');
                var stock_id = $(this).attr("data-id");

                $('.delete-modal-footer').html(
                    `<a href="/admin/delete-stock/${stock_id}" class="btn btn-primary">Yes</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>`
                );
                $('.delete-modal').html(
                    `<span>Are you sure you want to delete <strong>${name}</strong> request?</span>`);
            })
        })
    </script>
@endpush
