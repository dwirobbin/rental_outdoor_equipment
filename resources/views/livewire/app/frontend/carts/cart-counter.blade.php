<li class="nav-item @if (request()->routeIs('cart')) active @endif">
    <a href="{{ auth()->check() ? route('cart') : 'javascript:void(0)' }}" class="nav-link top-right cart">
        Keranjang
        <span class="badge badge-secondary bg-warning pt-1">{{ $totalItem }}</span>
    </a>
</li>
