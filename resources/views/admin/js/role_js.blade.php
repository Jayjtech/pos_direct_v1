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
                    `<div class="d-flex justify-content-between w-100">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="confirmRoleDelete">
                            <label class="form-check-label" for="confirmRoleDelete">
                                I understand this will affect user permissions
                            </label>
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                            <a href="/admin/delete-role/${role_id}" class="btn btn-danger" id="confirmRoleDeleteBtn" style="pointer-events: none; opacity: 0.5;">Delete Role</a>
                        </div>
                    </div>`
                );
                $('.delete-modal').html(
                    `<div class="alert alert-warning">
                        <h5><i class="fas fa-user-shield"></i> Delete Role</h5>
                        <p>You are about to permanently delete the role: <strong>${name}</strong></p>
                    </div>
                    <div class="alert alert-danger">
                        <strong>This action is irreversible!</strong>
                        <ul class="mb-0 mt-2">
                            <li>All permissions associated with this role will be removed</li>
                            <li>Users assigned to this role will lose these permissions</li>
                            <li>System roles (admin, super-admin) cannot be deleted</li>
                            <li>Roles assigned to users cannot be deleted</li>
                        </ul>
                    </div>
                    <div class="alert alert-info">
                        <strong>Before deleting:</strong> Ensure no users are currently assigned to this role, or reassign them to different roles first.
                    </div>`
                );
                
                // Enable/disable delete button based on checkbox
                $('#confirmRoleDelete').on('change', function() {
                    if ($(this).is(':checked')) {
                        $('#confirmRoleDeleteBtn').css({'pointer-events': 'auto', 'opacity': '1'});
                    } else {
                        $('#confirmRoleDeleteBtn').css({'pointer-events': 'none', 'opacity': '0.5'});
                    }
                });
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
