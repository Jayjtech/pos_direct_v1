<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ companyInfo()->company_name }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('ui/vendors/typicons.font/font/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('ui/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('ui/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('ui/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('ui/' . companyInfo()->company_logo) }}" />
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

        .product {
            cursor: pointer;
        }
    </style>
    @notifyCss
</head>

<body>
    <div class="overlay_1">
        <x-notify::notify />
    </div>

    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('ui/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('ui/js/off-canvas.js') }}"></script>
    <script src="{{ asset('ui/js/bootstrap.js') }}"></script>
    <script src="{{ asset('ui/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('ui/js/template.js') }}"></script>
    <script src="{{ asset('ui/js/settings.js') }}"></script>
    <script src="{{ asset('ui/js/todolist.js') }}"></script>

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
