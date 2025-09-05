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
                var deleteUserRoute = "{{ route('admin.delete.user', ':user_id') }}";
                var name = $(this).attr("href").replace(new RegExp('#', 'g'), '');
                var user_id = $(this).attr("data-id");
                var route = deleteUserRoute.replace(':user_id', user_id);

                $('.delete-modal-footer').html(
                    `<div class="d-flex justify-content-between w-100">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="confirmUserDelete" required>
                            <label class="form-check-label" for="confirmUserDelete">
                                I confirm this user deletion
                            </label>
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                            <a href="${route}" class="btn btn-danger" id="confirmUserDeleteBtn" style="pointer-events: none; opacity: 0.5;">Delete User</a>
                        </div>
                    </div>`
                );
                $('.delete-modal').html(
                    `<div class="alert alert-warning">
                        <h5><i class="fas fa-user-times"></i> Delete User Account</h5>
                        <p>You are about to permanently delete the user account: <strong>${name}</strong></p>
                    </div>
                    <div class="alert alert-danger">
                        <strong>This action is irreversible!</strong>
                        <ul class="mb-0 mt-2">
                            <li>User will no longer be able to access the system</li>
                            <li>All roles and permissions will be revoked</li>
                            <li>Active cart items will be deleted</li>
                            <li>User cannot be deleted if they have orders or transactions</li>
                        </ul>
                    </div>
                    <div class="alert alert-info">
                        <strong>Note:</strong> If the user has existing orders, transactions, or stock requests, the deletion will be prevented to maintain data integrity.
                    </div>`
                );
                
                // Enable/disable delete button based on checkbox
                $('#confirmUserDelete').on('change', function() {
                    if ($(this).is(':checked')) {
                        $('#confirmUserDeleteBtn').css({'pointer-events': 'auto', 'opacity': '1'});
                    } else {
                        $('#confirmUserDeleteBtn').css({'pointer-events': 'none', 'opacity': '0.5'});
                    }
                });
            })
        })
    </script>
@endpush
