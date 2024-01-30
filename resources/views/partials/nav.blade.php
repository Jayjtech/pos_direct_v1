<!-- partial:partials/_navbar.html -->
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo @if (request()->routeIs('shop')) mt-4 @endif"
            href="{{ route('dashboard') }}"><img src="{{ asset('ui/' . companyInfo()->company_logo) }}"
                alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}"><img
                src="{{ asset('ui/' . companyInfo()->company_logo) }}" alt="logo" /></a>
        <button class="navbar-toggler navbar-toggler align-self-center d-none d-lg-flex" type="button"
            data-toggle="minimize">
            <span class="typcn typcn-th-menu"></span>
        </button>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-2">
            @if (request()->routeIs('shop'))
                <li class="nav-item d-none d-lg-flex">
                    <a class="nav-link active" href="{{ route('dashboard') }}">
                        DASHBOARD
                    </a>
                </li>
            @else
                @can('order-report')
                    <li class="nav-item  d-none d-lg-flex">
                        <a class="nav-link @if (request()->routeIs('admin.order.list')) active @endif "
                            href="{{ route('admin.order.list') }}">
                            Order report
                        </a>
                    </li>
                @endcan
                @can('edit-user')
                    <li class="nav-item  d-none d-lg-flex">
                        <a class="nav-link @if (request()->routeIs('admin.user.list')) active @endif"
                            href="{{ route('admin.user.list') }}">
                            Users
                        </a>
                    </li>
                @endcan
                @can('create-role')
                    <li class="nav-item  d-none d-lg-flex">
                        <a class="nav-link @if (request()->routeIs('admin.role.list')) active @endif"
                            href="{{ route('admin.role.list') }}">
                            Roles & Permission
                        </a>
                    </li>
                @endcan
            @endif

        </ul>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle  pl-0 pr-0" href="#" data-toggle="dropdown"
                    id="profileDropdown">
                    <i class="typcn typcn-user-outline mr-0"></i>
                    <span class="nav-profile-name">{{ $lastName }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    @can('settings')
                        <a class="dropdown-item" href="{{ route('admin.company.info') }}">
                            <i class="typcn typcn-cog text-primary"></i>
                            Settings
                        </a>
                    @endcan

                    <form class="dropdown-item" action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" style="text-decoration: none;border:none;"><i
                                class="typcn typcn-power text-primary"></i>
                            Logout</button>
                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="typcn typcn-th-menu"></span>
        </button>
    </div>
</nav>
