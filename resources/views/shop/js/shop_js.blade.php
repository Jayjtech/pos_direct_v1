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

        const dailyActivity = async () => {
            const uuid = "{{ env('ACTIVATION_KEY') }}";

            if (!uuid) {
                console.log("Error: Account not activated. UUID not found!");
                window.location.href = "{{ route('admin.view-activation') }}";
                return;
            }

            const endpoint = "{{ env('API_BASE_URL') }}/api/subscription/decrement";
            const payload = {
                uuid
            };

            try {
                const response = await fetch(endpoint, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(payload),
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData?.message || `HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();
                console.log(data);

            } catch (err) {
                console.error("Error:", err.message);
            }
        };

        dailyActivity();
    </script>
@endpush
