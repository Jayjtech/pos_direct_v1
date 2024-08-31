@push('script')
    <script>
        "use strict";
        $(document).ready(function() {
            // Edit product
            $(document).on('click', '.edit-product a', function() {
                var product_id = $(this).attr("href").replace(new RegExp('#', 'g'), '');
                $.ajax({
                    url: "{{ route('admin.product.edit.view') }}",
                    type: "get",
                    data: {
                        product_id: product_id
                    },
                    success: function(response) {
                        $('.edit-modal').html(response.view)
                    }
                })
            })

            // Delete product
            $(document).on('click', '.delete-product a', function() {
                var name = $(this).attr("href").replace(new RegExp('#', 'g'), '');
                var product_id = $(this).attr("data-id");

                $('.delete-modal-footer').html(
                    `<p>Still want to proceed?</p> <a href="/admin/delete-product/${product_id}" class="btn btn-primary">Yes</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>`
                );
                $('.delete-modal').html(
                    `<span>Are you sure you want to delete <strong>${name}</strong>?</span>
                    <p class="font-weight-bold alert alert-danger">It is advisable not to delete any product; this is striclty recommended for accurate record-keeping! You can simply set the product's status to "Unavailable".</p>
                    `);
            })

            // Add product
            $(document).on('click', '.add-product a', function() {
                $.ajax({
                    url: "{{ route('admin.product.add.view') }}",
                    type: "get",
                    success: function(response) {
                        if (response.error) {
                            console.log(response);
                        } else {
                            $('.add-modal').html(response.view)
                        }
                    }
                })
            })

            // Add multiple product
            $(document).on('click', '.add-multiple-product a', function() {
                $.ajax({
                    url: "{{ route('admin.product.add.multiple.view') }}",
                    type: "get",
                    success: function(response) {
                        if (response.error) {
                            console.log(response);
                        } else {
                            $('.add-modal').html(response.view)
                        }
                    }
                })
            })




            // CATEGORY
            // Edit category
            $(document).on('click', '.edit-category a', function() {
                var category_id = $(this).attr("href").replace(new RegExp('#', 'g'), '');
                $.ajax({
                    url: "{{ route('admin.category.edit.view') }}",
                    type: "get",
                    data: {
                        category_id: category_id
                    },
                    success: function(response) {
                        if (response.error) {
                            console.log(response);
                        } else {
                            $('.edit-modal').html(response.view)
                        }
                    }
                })
            })

            // Delete category
            $(document).on('click', '.delete-category a', function() {
                var name = $(this).attr("href").replace(new RegExp('#', 'g'), '');
                var category_id = $(this).attr("data-id");
                var route = {{ route('admin.delete.product', category_id) }}

                $('.delete-modal-footer').html(
                    `<p>Still want to proceed?</p> <a href="${route}" class="btn btn-primary">Yes</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>`
                );
                $('.delete-modal').html(
                    `<span>Are you sure you want to delete <strong>${name}</strong>?</span>
                    <p class="font-weight-bold alert alert-danger">It is advisable not to delete any product category as all attached products will also be deleted; this is striclty recommended for accurate record-keeping! You can simply set the category's status to "Unavailable".</p>
                    `);
            })

            // Add product
            $(document).on('click', '.add-category a', function() {
                $.ajax({
                    url: "{{ route('admin.category.add.view') }}",
                    type: "get",
                    success: function(response) {
                        if (response.error) {
                            console.log(response);
                        } else {
                            $('.add-modal').html(response.view)
                        }
                    }
                })
            })

        })



        const previewPdt = () => {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("pdtImg").files[0]);

            oFReader.onload = function(oFREvent) {
                // CREATE NEW IMAGE OBJECT
                var img = new Image();
                img.onload = function() {
                    // RESIZE IMAGE
                    var canvas = document.createElement('canvas');
                    var ctx = canvas.getContext('2d');
                    var new_width = 400;
                    var new_height = 400;
                    canvas.width = new_width;
                    canvas.height = new_height;
                    ctx.drawImage(img, 0, 0, new_width, new_height);

                    // SET PREVIEW IMAGE SOURCE
                    document.getElementById("pdtPreview").src = canvas.toDataURL();

                    // CLEAN UP
                    canvas = null;
                    img = null;
                };
                img.src = oFREvent.target.result;
            };
        };
    </script>
@endpush


{{-- SQLSTATE[23000]: Integrity constraint violation: 1451 Cannot delete or update a parent row: a foreign key constraint fails (`ekreqipn_pos_v2`.`stocks`, CONSTRAINT `stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)) (SQL: delete from `products` where `id` = 2) --}}
{{-- QLSTATE[23000]: Integrity constraint violation: 1451 Cannot delete or update a parent row: a foreign key constraint fails (`ekreqipn_pos_v2`.`products`, CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)) (SQL: delete from `categories` where `id` = 2) --}}