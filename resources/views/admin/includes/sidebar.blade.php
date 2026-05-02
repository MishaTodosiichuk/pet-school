<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.home') }}" class="brand-link">
        <span class="brand-text font-weight-light">Головна</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @foreach($sidebarMenu as $item)
                    <li class="nav-item">
                        <a href="{{ $item['link'] }}"
                           class="nav-link {{ request()->routeIs($item['route_name']) ? 'active' : '' }}">
                            <i class="nav-icon {{ $item['icon'] }}"></i>
                            <p>{{ $item['title'] }}</p>
                        </a>
                    </li>
                @endforeach
                    <form class="nav-item logout-form" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link logout-button">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Вийти</p>
                        </button>
                    </form>
            </ul>
        </nav>
    </div>
</aside>
