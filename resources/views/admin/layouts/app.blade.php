<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Admin</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @stack('styles')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('head-scripts')
</head>

<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-gray-800">
                <div class="flex items-center justify-between h-16 px-4 bg-gray-900">
                    <div class="text-xl font-bold text-white">Carrio Motors</div>
                    <a href="{{ url('/') }}" class="text-white hover:text-blue-300" title="Visit Home Page" target="_blank">
                        <i class="fas fa-home text-lg"></i>
                    </a>
                </div>
                <div class="flex flex-col flex-grow overflow-y-auto">
                    <nav class="flex-1 px-2 py-4 space-y-1">
                        @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700">
                            <i class="mr-3 text-lg fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                        @else
                        <a href="{{ url('/dashboard') }}" class="flex items-center px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700">
                            <i class="mr-3 text-lg fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                        @endif
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'content')
                        @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.users.index') }}" class="flex items-center px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.users*') ? 'bg-gray-700' : '' }}">
                            <i class="mr-3 text-lg fas fa-users"></i>
                            Users
                        </a>
                        <a href="{{ route('activity-logs.index') }}" class="flex items-center px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700 {{ request()->routeIs('activity-logs*') ? 'bg-gray-700' : '' }}">
                            <i class="mr-3 text-lg fas fa-history"></i>
                            Activity Logs
                        </a>
                        @endif
                        <a href="{{ route('admin.makes.index') }}" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                            <i class="mr-3 text-lg fas fa-industry"></i>
                            Makes
                        </a>
                        <a href="{{ route('admin.models.index') }}" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                            <i class="mr-3 text-lg fas fa-car-side"></i>
                            Models
                        </a>
                        <a href="{{ route('admin.engines.index') }}" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                            <i class="mr-3 text-lg fas fa-cogs"></i>
                            Engines
                        </a>
                        <a href="{{ route('admin.car_colors.index') }}" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                            <i class="mr-3 text-lg fas fa-palette"></i>
                            Car Colors
                        </a>
                        <a href="{{ route('admin.cars.index') }}" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                            <i class="mr-3 text-lg fas fa-car"></i>
                            Cars
                        </a>
                        <a href="{{ route('admin.car_details.index') }}" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                            <i class="mr-3 text-lg fas fa-info-circle"></i>
                            Car Details
                        </a>
                        <a href="{{ route('admin.banners.index') }}" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                            <i class="mr-3 text-lg fas fa-images"></i>
                            Banners
                        </a>
                        @endif

        <main class="py-4">
            @if(session('success'))
                <div class="container">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="container">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);

        // Confirm delete actions
        $(document).on('submit', 'form[data-confirm]', function(e) {
            if (!confirm($(this).data('confirm'))) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
