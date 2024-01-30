@push('script')
    <script>
        "use strict";
        $(document).ready(function() {
            // Edit user
            $(document).on('click', '.edit-user a', function() {
                var user_id = $(this).attr("href").replace(new RegExp('#', 'g'), '');

                $.ajax({
                    url: "{{ route('admin.user.edit.view') }}",
                    type: "get",
                    data: {
                        user_id: user_id
                    },
                    success: function(response) {
                        $('.edit-modal').html(response.view)
                    }
                })
            })

            // Delete user
            $(document).on('click', '.delete-user a', function() {
                var name = $(this).attr("href").replace(new RegExp('#', 'g'), '');
                var user_id = $(this).attr("data-id");

                $('.delete-modal-footer').html(
                    `<a href="/admin/delete-user/${user_id}" class="btn btn-primary">Yes</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>`
                );
                $('.delete-modal').html(
                    `<span>Are you sure you want to delete <strong>${name}'s </strong> account?</span>`);
            })
        })
    </script>
@endpush
