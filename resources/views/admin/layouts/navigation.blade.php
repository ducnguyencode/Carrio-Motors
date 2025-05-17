<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-car"></i> Carrio Motors
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                       href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                @if(auth()->user()->role === 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                       href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users"></i> Users
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.cars.*') ? 'active' : '' }}"
                       href="{{ route('admin.cars.index') }}">
                        <i class="fas fa-car"></i> Cars
                    </a>
                </li>
                @if(in_array(auth()->user()->role, ['admin', 'saler']))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.invoices.*') ? 'active' : '' }}"
                       href="{{ route('admin.invoices.index') }}">
                        <i class="fas fa-file-invoice-dollar"></i> Invoices
                    </a>
                </li>
                @endif
                @if(in_array(auth()->user()->role, ['admin', 'content']))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs(['admin.makes.*', 'admin.models.*', 'admin.engines.*', 'admin.car_colors.*']) ? 'active' : '' }}"
                       href="#" id="navbarDropdownCatalog" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-book"></i> Catalog
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.makes.*') ? 'active' : '' }}"
                               href="{{ route('admin.makes.index') }}">
                                <i class="fas fa-industry"></i> Makes
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.models.*') ? 'active' : '' }}"
                               href="{{ route('admin.models.index') }}">
                                <i class="fas fa-car-side"></i> Models
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.engines.*') ? 'active' : '' }}"
                               href="{{ route('admin.engines.index') }}">
                                <i class="fas fa-cogs"></i> Engines
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.car_colors.*') ? 'active' : '' }}"
                               href="{{ route('admin.car_colors.index') }}">
                                <i class="fas fa-palette"></i> Colors
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}"
                       href="{{ route('admin.banners.index') }}">
                        <i class="fas fa-images"></i> Banners
                    </a>
                </li>
                @endif
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user"></i> {{ auth()->user()->username }}
                        <span class="badge bg-primary">{{ ucfirst(auth()->user()->role) }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
