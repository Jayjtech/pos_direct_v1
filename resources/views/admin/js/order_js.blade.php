@push('script')
    <script>
        "use script";
        $(document).ready(function() {
            $(document).on('click', '.refund-order a', function() {
                var name = $(this).attr("href").replace(new RegExp('#', 'g'), '');
                var order_id = $(this).attr("data-id");

                $.ajax({
                    url: "{{ route('admin.refund.order.view') }}",
                    type: "get",
                    data: {
                        name: name,
                        order_id: order_id
                    },
                    success: function(response) {
                        if (response.error) {
                            console.log(response.error)
                        } else {
                            $('.refund-modal').html(response.view)
                        }
                    }
                })
            })

            // Check input fields
            isChecked = false;
            $(document).on('click', '#checkAll', function() {
                isChecked = !isChecked;
                $('input[type="checkbox"]').prop('checked', isChecked);
            })

            // Search order
            $(document).on('keyup', '#searchOrder', function(e) {
                e.preventDefault();
                var search = ($(this).val());
                $.ajax({
                    url: "{{ route('admin.search.order') }}",
                    type: "get",
                    data: {
                        search: search
                    },
                    success: function(response) {
                        $('.get-pdf').html(` <a href="/admin/order-pdf/${search}" class="btn btn-sm btn-danger"><i
                                class="mdi mdi-file-pdf"></i>PDF</a>`);
                        $(".display-order").html(response)
                        if (response.status === 0) {
                            $(".display-order").html(
                                `<p class="alert alert-danger">${response.message}</p>`)
                        }
                    }
                })
            })

            // Set the min attribute of the endDate input to the selected startDate
            document.getElementById('startDate').addEventListener('change', function() {
                document.getElementById('endDate').min = this.value;
            });

        })
    </script>
@endpush
