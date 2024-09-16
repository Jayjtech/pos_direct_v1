<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <div class="d-flex sidebar-profile">
                <div class="sidebar-profile-image">
                    <img src="{{ asset('ui/images/default_img.png') }}" alt="image">
                    <span class="sidebar-status-indicator"></span>
                </div>
                <div class="sidebar-profile-name">
                    <p class="sidebar-name">
                        {{ $lastName }}
                    </p>
                    <p class="sidebar-designation">
                        Welcome
                    </p>
                </div>
            </div>

            <p class="sidebar-menu-title">Dash menu</p>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="mdi mdi-view-dashboard menu-icon"></i>
                <span class="menu-title">DASHBOARD</span>
            </a>
        </li>
        @can('shop')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('shop') }}">
                    <i class="mdi mdi-shopping menu-icon"></i>
                    <span class="menu-title">SHOP</span>
                </a>
            </li>
        @endcan

        @can('list-stock')
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false"
                    aria-controls="form-elements">
                    <i class="mdi mdi-store menu-icon"></i>
                    <span class="menu-title">STORE</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="form-elements">
                    <ul class="nav flex-column sub-menu">
                        @can('create-product-category')
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.list.categories') }}">Category
                                    list</a>
                            </li>
                        @endcan
                        @can('create-product')
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.product.list') }}">Product list</a>
                            </li>
                        @endcan
                        @can('request-stock')
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.stock.request.list') }}">Request
                                    Stock</a>
                            </li>
                        @endcan
                        @can('approve-stock')
                            <li class="nav-item"><a class="nav-link"
                                    href="{{ route('admin.stock.request.approval.list') }}">Approve
                                    Stock
                                    request</a>
                            </li>
                        @endcan
                        @can('request-stock')
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.stock.approval.logs') }}">Approval
                                    Logs</a>
                            </li>
                        @endcan

                    </ul>
                </div>
            </li>
        @endcan

        @can('generate-receipt')
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                    <i class="mdi mdi-file-outline menu-icon"></i>
                    <span class="menu-title">REPORTS</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="charts">
                    <ul class="nav flex-column sub-menu">
                        @can('generate-receipt')
                            <li class="nav-item"> <a class="nav-link" href="{{ route('admin.order.list') }}">Orders Report</a>
                            </li>
                        @endcan
                        @can('generate-receipt')
                            <li class="nav-item"> <a class="nav-link" href="{{ route('admin.refunded-order.list') }}">Refunded
                                    Orders</a>
                            </li>
                        @endcan
                        @can('order-report')
                            <li class="nav-item"> <a class="nav-link" href="{{ route('admin.sales.report') }}">Sales Report</a>
                            </li>
                        @endcan
                        @can('order-report')
                            <li class="nav-item"> <a class="nav-link" href="{{ route('admin.cashflow') }}">Cashflow</a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcan

        @can('settings')
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                    <i class="mdi mdi-settings menu-icon"></i>
                    <span class="menu-title">SETTINGS</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="tables">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{ route('admin.company.info') }}">Company
                                Info</a></li>

                        <li class="nav-item"> <a class="nav-link" href="{{ route('admin.user.list') }}">Users</a></li>

                        <li class="nav-item"> <a class="nav-link" href="{{ route('admin.role.list') }}">Roles &
                                Permissions</a></li>
                    </ul>
                </div>

            </li>
        @endcan

    </ul>
</nav>
