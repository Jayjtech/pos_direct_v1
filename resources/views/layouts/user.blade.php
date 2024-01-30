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

    <!-- End custom js for this page-->
    @stack('script')
    @notifyJs
</body>

</html>
