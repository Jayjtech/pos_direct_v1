@push('script')
    <script>
        "use strict";
        $(document).ready(function() {
            // Edit user
            $(document).on('click', '.edit-role a', function() {
                var role_id = $(this).attr("href").replace(new RegExp('#', 'g'), '');

                $.ajax({
                    url: "{{ route('admin.role.edit.view') }}",
                    type: "get",
                    data: {
                        role_id: role_id
                    },
                    success: function(response) {
                        if (response.error) {
                            console.log(response.error)
                        } else {
                            $('.edit-modal').html(response.view)
                        }
                    }
                })
            })

            // Delete role
            $(document).on('click', '.delete-role a', function() {
                var name = $(this).attr("href").replace(new RegExp('#', 'g'), '');
                var role_id = $(this).attr("data-id");

                $('.delete-modal-footer').html(
                    `<a href="/admin/delete-role/${role_id}" class="btn btn-primary">Yes</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>`
                );
                $('.delete-modal').html(
                    `<span>Are you sure you want to delete <strong>${name}</strong> role?</span>`);
            })

            // Add role
            $(document).on('click', '.add-role a', function() {
                $.ajax({
                    url: "{{ route('admin.role.add.view') }}",
                    type: "get",
                    success: function(response) {
                        if (response.error) {
                            console.log(response.error)
                        } else {
                            $('.add-modal').html(response.view)
                        }
                    }
                })
            })
        })
    </script>
@endpush
