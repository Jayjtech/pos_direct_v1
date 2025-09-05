<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ companyInfo()->company_name }}</title>
    <!-- base:css -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('ui/vendors/typicons.font/font/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('ui/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('ui/vendors/mdi/css/materialdesignicons.min.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('ui/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('ui/' . companyInfo()->company_logo) }}" />
    @notifyCss
    <style>
        .overlay_1 {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* Semi-transparent black overlay */
            z-index: 9998;
            pointer-events: none;
        }

        x-notify::notify {
            z-index: 9999;
            /* Set a higher z-index than the overlay */
        }
    </style>
    {{-- Monnify SDK --}}
    <script type="text/javascript" src="https://sdk.monnify.com/plugin/monnify.js"></script>
</head>


<body>

    <div class="overlay_1">
        <x-notify::notify />
    </div>

    <div class="container-scroller">
        {{-- nav --}}
        @include('partials.nav')
        {{-- skin --}}
        @include('partials.skin')
        {{-- sidebar --}}
        @include('partials.sidebar')

        @yield('content')

        {{-- Footer --}}
        @include('partials.footer')
        <!-- partial -->
    </div>

    <!-- base:js -->
    <script src="{{ asset('ui/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('ui/js/bootstrap.js') }}"></script>
    <script src="{{ asset('ui/js/off-canvas.js') }}"></script>
    <script src="{{ asset('ui/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('ui/js/template.js') }}"></script>
    <script src="{{ asset('ui/js/settings.js') }}"></script>
    <script src="{{ asset('ui/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <script src="{{ asset('ui/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('ui/vendors/chart.js/Chart.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- Custom js for this page-->
    <script src="{{ asset('ui/js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- End custom js for this page-->
    @stack('script')
    <script>
        const fetchPlan = async () => {
            const endpoint = "{{ env('API_BASE_URL') }}/api/subscription/me";
            const params = {
                uuid: "{{ env('ACTIVATION_KEY') }}"
            };

            try {
                // Construct query string from params
                const queryString = new URLSearchParams(params).toString();
                const url = `${endpoint}?${queryString}`;

                const response = await fetch(url, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                    },
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();

                if (data?.subscription?.status !== "active") {
                    // Get the current route from the URL
                    const currentRoute = window.location.pathname;

                    // Redirect ONLY if the user is NOT already on "admin.view-activation"
                    if (!currentRoute.includes("admin/account-activation")) {
                        window.location.href = "{{ route('admin.view-activation') }}";
                    }
                }
            } catch (error) {
                console.error("Error fetching plan:", error.message);
            }
        };

        // Call the function
        fetchPlan();
    </script>
    @notifyJs
</body>

</html>
