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
    <link rel="stylesheet" href="{{ asset('ui/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('ui/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('ui/' . companyInfo()->company_logo) }}" />
    <!-- Include Notify.js library -->

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('ui/' . companyInfo()->company_logo) }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    @notifyCss
</head>

<body>
    <x-notify::notify />
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="{{ asset('ui/' . companyInfo()->company_logo) }}" alt="logo">
                            </div>

                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    <script src="{{ asset('ui/vendors/js/vendor.bundle.base.js') }}"></script>

    <script src="{{ asset('ui/js/off-canvas.js') }}"></script>
    <script src="{{ asset('ui/js/bootstrap.js') }}"></script>
    <script src="{{ asset('ui/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('ui/js/template.js') }}"></script>
    <script src="{{ asset('ui/js/settings.js') }}"></script>
    <script src="{{ asset('ui/js/todolist.js') }}"></script>
    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if ("serviceWorker" in navigator) {
            // Register a service worker hosted at the root of the
            // site using the default scope.
            navigator.serviceWorker.register("/sw.js").then(
                (registration) => {
                    console.log("Service worker registration succeeded:", registration);
                },
                (error) => {
                    console.error(`Service worker registration failed: ${error}`);
                },
            );
        } else {
            console.error("Service workers are not supported.");
        }
    </script>
    @notifyJs
</body>

</html>
