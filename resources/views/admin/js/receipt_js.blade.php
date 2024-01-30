@push('script')
    <script>
        "use strict"
        $(document).ready(function() {
            // Print
            window.print();

            // Redirect when 'b' is clicked
            document.addEventListener('keydown', function(event) {
                // if (event.key === 'b') {
                window.location.href = document.referrer
                // }
            });
        })
    </script>
@endpush
