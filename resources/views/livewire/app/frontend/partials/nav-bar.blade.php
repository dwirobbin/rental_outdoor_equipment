<div>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Outdoor<span>AF</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span>
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav mx-auto ">
                    <li class="nav-item @if (request()->routeIs('home')) active @endif">
                        <a href="{{ route('home') }}" class="nav-link">Beranda</a>
                    </li>
                    <li class="nav-item @if (request()->routeIs('equipment')) active @endif">
                        <a href="{{ route('equipment') }}" class="nav-link">Peralatan</a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    @livewire('app.frontend.carts.cart-counter')
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link top-right dropdown-toggle dashboard-area" href="#" data-toggle="dropdown"
                                aria-expanded="false">{{ auth()->user()->name }}</a>
                            <div class="dropdown-menu">
                                @if (auth()->user()->role->name == 'admin')
                                    <a href="{{ route('admin_area.dashboard') }}" class="dropdown-item">
                                        Area Admin
                                    </a>
                                @else
                                    <a href="{{ route('customer_area.dashboard') }}" class="dropdown-item">
                                        Area Pelanggan
                                    </a>
                                @endif
                                <button wire:click='logoutHandler' class="dropdown-item" type="button">
                                    Keluar
                                </button>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('auth.login') }}" class="nav-link top-right btn btn-primary">
                                Masuk
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</div>
