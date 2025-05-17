<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrio Motors Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: #fff;
            z-index: 1000;
            transition: all 0.3s;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .main-content {
            margin-left: 250px;
            transition: all 0.3s;
            padding: 20px;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.7);
            padding: 12px 20px;
            border-radius: 5px;
            margin-bottom: 5px;
            transition: all 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
        }

        .sidebar-header {
            padding: 20px;
            background: rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
        }

        .sidebar-logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
        }

        .topbar {
            background-color: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            padding: 15px 30px;
            margin-bottom: 24px;
            border-radius: 10px;
        }

        .dropdown-menu {
            min-width: 12rem;
            right: 0;
        }

        .nav-divider {
            margin: 15px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0 20px;
        }

        .nav-header {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 20px;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        /* Card styles */
        .card {
            border-radius: 10px;
            border: none;
        }

        .card-header {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        /* Button styles */
        .btn {
            border-radius: 5px;
            padding: 0.5rem 1rem;
        }

        /* Badge styles */
        .badge {
            padding: 0.5em 0.8em;
        }

        /* Table styles */
        .table th {
            font-weight: 600;
            vertical-align: middle;
        }

        /* Custom gradients */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #4f46e5, #0ea5e9);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #f59e0b, #f97316);
        }

        .bg-gradient-danger {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar.active {
                margin-left: 0;
            }

            .main-content.active {
                margin-left: 250px;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">CARRIO MOTORS</div>
            <div class="small">Admin Dashboard</div>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>

            <div class="nav-divider"></div>

            <div class="nav-header">User Management</div>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i> Users
                </a>
            </li>

            <div class="nav-divider"></div>

            <div class="nav-header">Vehicle Management</div>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-car"></i> Cars
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-tags"></i> Models
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-industry"></i> Manufacturers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-cogs"></i> Engines
                </a>
            </li>

            <div class="nav-divider"></div>

            <div class="nav-header">Marketing</div>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/banners*') ? 'active' : '' }}" href="{{ route('admin.banners.index') }}">
                    <i class="fas fa-image"></i> Banners
                </a>
            </li>

            <div class="nav-divider"></div>

            <div class="nav-header">Sales</div>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/invoices*') ? 'active' : '' }}" href="{{ route('admin.invoices.index') }}">
                    <i class="fas fa-file-invoice-dollar"></i> Invoices
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-chart-bar"></i> Reports
                </a>
            </li>

            <div class="nav-divider"></div>

            <li class="nav-item mt-3">
                <a class="nav-link" href="{{ url('/') }}" target="_blank">
                    <i class="fas fa-external-link-alt"></i> View Website
                </a>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link text-left w-100" style="background: none; border: none;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar d-flex justify-content-between align-items-center mb-4">
            <div>
                <button class="btn btn-link text-decoration-none d-md-none" id="sidebarToggleBtn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <div>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <span class="mr-2 d-none d-lg-inline text-gray-600">{{ Auth::user()->fullname }}</span>
                        <div class="d-inline-block bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <span class="text-white fw-bold">{{ substr(Auth::user()->fullname, 0, 1) }}</span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in">
                        <a class="dropdown-item" href="{{ route('admin.users.show', Auth::id()) }}">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggleBtn').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
            document.querySelector('.main-content').classList.toggle('active');
        });
    </script>
</body>
</html>
