<div class="leftside-menu">

    <!-- LOGO -->
    <a href="{{ route('home') }}" class="logo text-center logo-light">
        <span class="logo-lg">
            <h3 class="mt-3">{{ config('app.name') }}</h3>
        </span>
        <span class="logo-sm">
            <h3 class="mt-3">AF</h3>
        </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar="">

        <!--- Sidemenu -->
        <ul class="side-nav">
            <li class="side-nav-title side-nav-item">Main Menu</li>

            @can('isAdmin')
                <li class="side-nav-item @if (in_array(Route::current()->getName(), ['admin_area.dashboard'])) menuitem-active @endif">
                    <a href="{{ route('admin_area.dashboard') }}" aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link">
                        <i class="uil-home-alt"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                <li class="side-nav-item @if (request()->routeIs('admin_area.equipment.index')) menuitem-active @endif">
                    <a href="{{ route('admin_area.equipment.index') }}" aria-expanded="false" aria-controls="sidebarDashboards"
                        class="side-nav-link">
                        <i class="uil-layer-group"></i>
                        <span> Peralatan </span>
                    </a>
                </li>
                <li class="side-nav-item @if (request()->routeIs('admin_area.payment_method.*')) menuitem-active @endif">
                    <a href="{{ route('admin_area.payment_method.index') }}" class="side-nav-link">
                        <i class="uil-atm-card"></i>
                        <span> Metode Pembayaran </span>
                    </a>
                </li>
                <li class="side-nav-item @if (request()->routeIs('admin_area.billing.*')) menuitem-active @endif">
                    <a href="{{ route('admin_area.billing.index') }}" class="side-nav-link">
                        <i class="uil-bill"></i>
                        <span> Tagihan </span>
                    </a>
                </li>
                <li class="side-nav-item @if (request()->routeIs('admin_area.order.*')) menuitem-active @endif">
                    <a href="{{ route('admin_area.order.index') }}" class="side-nav-link">
                        <i class="uil-clipboard-alt"></i>
                        <span> Pesanan </span>
                    </a>
                </li>
                <li class="side-nav-item @if (request()->routeIs('admin_area.user_management.*')) menuitem-active @endif">
                    <a href="{{ route('admin_area.user_management.index') }}" class="side-nav-link">
                        <i class="uil-users-alt"></i>
                        <span> Manajemen User </span>
                    </a>
                </li>
            @else
                <li class="side-nav-item @if (in_array(Route::current()?->getName(), ['customer_area.dashboard'])) menuitem-active @endif">
                    <a href="{{ route('customer_area.dashboard') }}" aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link">
                        <i class="uil-home-alt"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                <li class="side-nav-item @if (request()->routeIs('customer_area.billing.*')) menuitem-active @endif">
                    <a href="{{ route('customer_area.billing.index') }}" class="side-nav-link">
                        <i class="uil-bill"></i>
                        <span> Tagihan Saya </span>
                    </a>
                </li>
                <li class="side-nav-item @if (request()->routeIs('customer_area.order.*')) menuitem-active @endif">
                    <a href="{{ route('customer_area.order.index') }}" class="side-nav-link">
                        <i class="uil-clipboard-alt"></i>
                        <span> Pesanan Saya </span>
                    </a>
                </li>
                <li class="side-nav-item @if (request()->routeIs('customer_area.user_management.*')) menuitem-active @endif">
                    <a href="{{ route('customer_area.user_management.index') }}" class="side-nav-link">
                        <i class="uil-user"></i>
                        <span> Pengaturan Akun </span>
                    </a>
                </li>
            @endcan
        </ul>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
