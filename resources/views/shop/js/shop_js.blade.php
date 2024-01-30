@push('script')
    <script>
        "use strict"
        $(document).ready(function() {
            // Search Product
            $(document).on('keyup', '#searchProduct', function(e) {
                e.preventDefault();
                var search = ($(this).val());
                $.ajax({
                    url: "{{ route('search.product') }}",
                    type: "get",
                    data: {
                        search: search
                    },
                    success: function(response) {
                        $(".product-display").html(response)
                        if (response.status === 0) {
                            $(".product-display").html(
                                `<p class="alert alert-danger">${response.message}</p>`)
                        }
                    }
                })
            })


            // Ajax Paginate
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                // Split the link in the href
                var page = $(this).attr('href').split('page=')[1]
                $.ajax({
                    url: "/pagination/paginate-products?page=" + page,
                    success: function(response) {
                        $(".product-display").html(response)
                    }
                })
            })
        })
    </script>
@endpush
