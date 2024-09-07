@push('script')
    <script>
        "use strict";
        $(document).ready(function() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            // Adding product to cart
            $(document).on('click', '.product a', function(e) {
                e.preventDefault();
                // Removing the # before the href value
                var product_id = $(this).attr('href').replace(new RegExp('#', 'g'), '')

                $.ajax({
                    url: "{{ route('add.to.cart') }}",
                    type: "post",
                    data: {
                        product_id: product_id
                    },
                    headers: {
                        "X-CSRF-TOKEN": csrfToken
                    },
                    success: function(response) {
                        console.log(response)
                        $("#grand-total").html(
                            `<span>Grand Total: {!! config('basic.c_s') !!}${new Intl.NumberFormat().format(parseFloat(response.grand_total))}</span>`
                        )
                        $('.cart-display').html(response.html);
                        $('.variety').html(
                            `<i class="mdi mdi-cart"></i> Variety: ${response.variety}</span>`
                        )
                        $("#response").html(
                            `<span class="alert alert-${response.json.icon}">${response.json.message}</span>`
                        )
                        $(".tab-display").html(response.tab_view);
                        $(".payment-method-container").html(response.pm_method_view);
                        // change the value of the tab to the active-id
                        $(".new-tab").attr('active-tab', response.active_tab);
                        // Scrolldown cart container
                        scrollToBottom()
                    }
                })
            })

            // Removing a product from the cart
            $(document).on('click', '.remove-product a', function(e) {
                e.preventDefault();
                var cartRowId = $(this).attr('href').replace(new RegExp('#', 'g'), '');

                $.ajax({
                    url: "{{ route('remove.from.cart') }}",
                    type: "post",
                    data: {
                        cartRowId: cartRowId
                    },
                    headers: {
                        "X-CSRF-TOKEN": csrfToken
                    },
                    success: function(response) {
                        $("#grand-total").html(
                            `<span>Grand Total: {!! config('basic.c_s') !!}${new Intl.NumberFormat().format(parseFloat(response.grand_total))}</span>`
                        )
                        $('.cart-display').html(response.html);
                        $('.variety').html(
                            `<i class="mdi mdi-cart"></i> Variety: ${response.variety}</span>`
                        )
                        $("#response").html(
                            `<span class="alert alert-${response.json.icon}">${response.json.message}</span>`
                        )
                    }
                })
            })

            // Change Quantity
            $(document).on('change blur', '.qty-form input', function() {
                var id = $(this).attr('id');
                var qty = $(this).val();

                $.ajax({
                    url: "{{ route('change.qty') }}",
                    type: "post",
                    data: {
                        id: id,
                        qty: qty
                    },
                    headers: {
                        "X-CSRF-TOKEN": csrfToken
                    },
                    success: function(response) {
                        $("#grand-total").html(
                            `<span>Grand Total: {!! config('basic.c_s') !!}${new Intl.NumberFormat().format(parseFloat(response.grand_total))}</span>`
                        )
                        $('.cart-display').html(response.html);
                        $('.variety').html(
                            `<i class="mdi mdi-cart"></i> Variety: ${response.variety}</span>`
                        )
                        $("#response").html(
                            `<span class="alert alert-${response.json.icon}">${response.json.message}</span>`
                        )
                    }
                })
            })


            // Change Discount
            $(document).on('change blur', '.discount-form input', function() {
                var id = $(this).attr('id');
                var discount = $(this).val();

                $.ajax({
                    url: "{{ route('change.discount') }}",
                    type: "post",
                    data: {
                        id: id,
                        discount: discount
                    },
                    headers: {
                        "X-CSRF-TOKEN": csrfToken
                    },
                    success: function(response) {
                        $("#grand-total").html(
                            `<span>Grand Total: {!! config('basic.c_s') !!}${new Intl.NumberFormat().format(parseFloat(response.grand_total))}</span>`
                        )
                        $('.cart-display').html(response.html);
                        $('.variety').html(
                            `<i class="mdi mdi-cart"></i> Variety: ${response.variety}</span>`
                        )
                        $("#response").html(
                            `<span class="alert alert-${response.json.icon}">${response.json.message}</span>`
                        )
                    }
                })
            })

            $(document).on("click", ".check-discount input", function() {
                var tag = $(this).attr("id");
                if ($(this).prop("checked")) {
                    $("#" + tag).val("checked");
                } else {
                    $("#" + tag).val("unchecked");
                }

                var status = $("#" + tag).val();
                var id = tag.split("_")[1];

                if (status == "unchecked") {
                    var discount = 0;
                } else {
                    var discount = $("#label_" + id).text();
                }

                $.ajax({
                    url: "{{ route('change.discount') }}",
                    type: "post",
                    data: {
                        id: id,
                        status: status,
                        discount: discount
                    },
                    headers: {
                        "X-CSRF-TOKEN": csrfToken
                    },
                    success: function(response) {
                        $("#grand-total").html(
                            `<span>Grand Total: {!! config('basic.c_s') !!}${new Intl.NumberFormat().format(parseFloat(response.grand_total))}</span>`
                        )
                        $('.cart-display').html(response.html);
                        $('.variety').html(
                            `<i class="mdi mdi-cart"></i> Variety: ${response.variety}</span>`
                        )
                        $("#response").html(
                            `<span class="alert alert-${response.json.icon}">${response.json.message}</span>`
                        )

                    }
                })
            });


            // Add checkout method
            $(document).on('click', '.checkout-methods button', function() {
                var checkout_method = $(this).attr('data-id');
                var cart_report_id = $(this).attr('data-cart-report-id');

                $.ajax({
                    url: "{{ route('add.checkout.method') }}",
                    type: "get",
                    data: {
                        checkout_method: checkout_method,
                        cart_report_id: cart_report_id
                    },
                    success: function(response) {
                        $("#response").html(
                            `<span class="alert alert-${response.json.icon}">${response.json.message}</span>`
                        )
                        $(".payment-method-container").html(response.pm_method_view);
                    }
                })
            })

            // Create new tab
            $(document).on('click', '.new-tab', function() {
                var active_tab = $(this).attr('active-tab');

                $.ajax({
                    url: "{{ route('create.new.tab') }}",
                    type: "get",
                    data: {
                        active_tab: active_tab
                    },
                    success: function(response) {
                        $("#grand-total").html(
                            `<span>Grand Total: {!! config('basic.c_s') !!}${new Intl.NumberFormat().format(parseFloat(response.grand_total))}</span>`
                        )
                        $('.cart-display').html(response.html);
                        $('.variety').html(
                            `<i class="mdi mdi-cart"></i> Variety: 0</span>`
                        )
                        $("#response").html(
                            `<span class="alert alert-${response.json.icon}">${response.json.message}</span>`
                        )
                        $(".payment-method-container").html(response.pm_method_view);
                        $(".tab-display").html(response.tab_view);
                        // change the value of the tab to the active-id
                        $(".new-tab").attr('active-tab', response.active_tab);
                    }
                })
            })

            //Tab request 
            $(document).on('click', '.tab-nav a', function() {
                var data = $(this).attr('href').replace(new RegExp('#', 'g'), '');
                var query = data.split('_')[0];
                var tab_id = data.split('_')[1];

                $.ajax({
                    url: "{{ route('tab.request') }}",
                    type: "post",
                    data: {
                        query: query,
                        tab_id: tab_id
                    },
                    headers: {
                        "X-CSRF-TOKEN": csrfToken
                    },
                    success: function(response) {
                        $("#grand-total").html(
                            `<span>Grand Total: {!! config('basic.c_s') !!}${new Intl.NumberFormat().format(parseFloat(response.grand_total))}</span>`
                        )
                        $('.cart-display').html(response.html);
                        $('.variety').html(
                            `<i class="mdi mdi-cart"></i> Variety: ${response.variety}</span>`
                        )
                        $("#response").html(
                            `<span class="alert alert-${response.json.icon}">${response.json.message}</span>`
                        )
                        $(".tab-display").html(response.tab_view);
                        $(".payment-method-container").html(response.pm_method_view);
                        // change the value of the tab to the active-id
                        $(".new-tab").attr('active-tab', response.active_tab);
                    }
                })
            })

            // Search invoice
            $(document).on('blur', '.get-invoice', function() {
                var invoice_code = $(this).val().toLowerCase();

                if (invoice_code) {
                    $.ajax({
                        url: "{{ route('tab.request') }}",
                        type: "post",
                        data: {
                            query: "view",
                            invoice_code: invoice_code
                        },
                        headers: {
                            "X-CSRF-TOKEN": csrfToken
                        },
                        success: function(response) {
                            if (response.error) {
                                $("#response").html(
                                    `<span class="alert alert-${response.icon}">${response.message}</span>`
                                )
                            } else {
                                $("#grand-total").html(
                                    `<span>Grand Total: {!! config('basic.c_s') !!}${new Intl.NumberFormat().format(parseFloat(response.grand_total))}</span>`
                                )
                                $('.cart-display').html(response.html);
                                $('.variety').html(
                                    `<i class="mdi mdi-cart"></i> Variety: ${response.variety}</span>`
                                )
                                $("#response").html(
                                    `<span class="alert alert-${response.json.icon}">${response.json.message}</span>`
                                )
                                $(".tab-display").html(response.tab_view);
                                $(".payment-method-container").html(response.pm_method_view);
                                // change the value of the tab to the active-id
                                $(".new-tab").attr('active-tab', response.active_tab);
                            }
                        }
                    })
                }

            })

            $(document).on('blur', '.cart-buyer-name', function() {
                var buyer = $(this).val();

                $.ajax({
                    url: "{{ route('add.buyer.name') }}",
                    type: "get",
                    data: {
                        buyer: buyer
                    },
                    success: function(response) {
                        $("#response").html(
                            `<span class="alert alert-${response.json.icon}">${response.json.message}</span>`
                        );
                        $('.cart-display').html(response.html);
                        $(".tab-display").html(response.tab_view);
                        $(
                            ".payment-method-container").html(response.pm_method_view);
                        // change the value of the tab to the active-id
                        $(".new-tab").attr('active-tab', response.active_tab);
                    }
                })
            })
            // End of Ajax
        })

        $(document).on('click', '.print-receipt', function() {
            var id = $(this).attr("href").replace(new RegExp('#', 'g'), '');
            var checkoutMethod = $("#checkoutMethod").val();

            if (parseInt(checkoutMethod) === 0) {
                $("#response").html(
                    `<span class="alert alert-danger"><strong>Please select checkout method!</strong></span>`
                );
            } else {
                var receiptUrl = generateReceiptRoute.replace(':id', id);
                window.location.href = receiptUrl;
            }
        });

        function scrollToBottom() {
            var myDiv = document.querySelector('.cart-display');
            myDiv.scrollTop = myDiv.scrollHeight;
        }
    </script>
@endpush
