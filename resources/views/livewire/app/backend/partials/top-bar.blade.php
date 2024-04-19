<div class="navbar-custom">
    <ul class="list-unstyled topbar-menu float-end mb-0">

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                aria-expanded="false">
                <span class="account-user-avatar">
                    <img src="{{ asset('src/backend/images/no_image.png') }}" alt="user-image" class="rounded-circle">
                </span>
                <span>
                    <span class="account-user-name">{{ auth()?->user()?->name }}</span>
                    <span class="account-position">{{ str(auth()?->user()?->role->name)->title() }}</span>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                <div class=" dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Selamat datang!</h6>
                </div>

                <a href="{{ route('home') }}" class="dropdown-item notify-item">
                    <i class="mdi mdi-home me-1"></i>
                    <span>Kembali ke Utama</span>
                </a>

                <button type="button" wire:click='logoutHandler' class="dropdown-item notify-item">
                    <i class="mdi mdi-logout me-1"></i>
                    <span>Logout</span>
                </button>
            </div>
        </li>

    </ul>
    <button class="button-menu-mobile open-left">
        <i class="mdi mdi-menu"></i>
    </button>
</div>
