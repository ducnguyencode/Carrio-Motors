<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?> - Carrio Motors Admin</title>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-gray-800">
                <div class="flex items-center justify-between h-16 px-4 bg-gray-900">
                    <div class="text-xl font-bold text-white">Carrio Motors</div>
                    <a href="<?php echo e(url('/')); ?>" class="text-white hover:text-blue-300" title="Visit Home Page" target="_blank">
                        <i class="fas fa-home text-lg"></i>
                    </a>
                </div>
                <div class="flex flex-col flex-grow overflow-y-auto">
                    <nav class="flex-1 px-2 py-4 space-y-1">
                        <?php if(auth()->user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700">
                            <i class="mr-3 text-lg fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                        <?php else: ?>
                        <a href="<?php echo e(url('/dashboard')); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700">
                            <i class="mr-3 text-lg fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                        <?php endif; ?>
                        <?php if(auth()->user()->role === 'admin' || auth()->user()->role === 'content'): ?>
                        <?php if(auth()->user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700 <?php echo e(request()->routeIs('admin.users*') ? 'bg-gray-700' : ''); ?>">
                            <i class="mr-3 text-lg fas fa-users"></i>
                            Users
                        </a>
                        <a href="<?php echo e(route('activity-logs.index')); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700 <?php echo e(request()->routeIs('activity-logs*') ? 'bg-gray-700' : ''); ?>">
                            <i class="mr-3 text-lg fas fa-history"></i>
                            Activity Logs
                        </a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('admin.makes.index')); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                            <i class="mr-3 text-lg fas fa-industry"></i>
                            Makes
                        </a>
                        <a href="<?php echo e(route('admin.models.index')); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                            <i class="mr-3 text-lg fas fa-car-side"></i>
                            Models
                        </a>
                        <a href="<?php echo e(route('admin.engines.index')); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                            <i class="mr-3 text-lg fas fa-cogs"></i>
                            Engines
                        </a>
                        <a href="<?php echo e(route('admin.car_colors.index')); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                            <i class="mr-3 text-lg fas fa-palette"></i>
                            Car Colors
                        </a>
                        <a href="<?php echo e(route('admin.cars.index')); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                            <i class="mr-3 text-lg fas fa-car"></i>
                            Cars
                        </a>
                        <a href="<?php echo e(route('admin.car_details.index')); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                            <i class="mr-3 text-lg fas fa-info-circle"></i>
                            Car Details
                        </a>
                        <a href="<?php echo e(route('admin.banners.index')); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                            <i class="mr-3 text-lg fas fa-images"></i>
                            Banners
                        </a>
                        <?php endif; ?>

                        <?php if(auth()->user()->role === 'admin' || auth()->user()->role === 'saler'): ?>
                        <?php if(auth()->user()->role === 'saler'): ?>
                        <a href="<?php echo e(route('admin.cars.index')); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                            <i class="mr-3 text-lg fas fa-car"></i>
                            Cars
                        </a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('admin.invoices.index')); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                            <i class="mr-3 text-lg fas fa-file-invoice-dollar"></i>
                            Invoices
                        </a>
                        <?php endif; ?>
                        <?php if(auth()->user()->role === 'user'): ?>
                        <a href="<?php echo e(url('/dashboard')); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                            <i class="mr-3 text-lg fas fa-file-invoice-dollar"></i>
                            Purchase History
                        </a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col flex-1 w-0 overflow-hidden">
            <div class="relative z-10 flex flex-shrink-0 h-16 bg-white shadow">
                <button id="sidebarToggle" class="px-4 border-r border-gray-200 text-gray-500 md:hidden focus:outline-none focus:bg-gray-100 focus:text-gray-600">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="flex justify-between flex-1 px-4">
                    <div class="flex flex-1">
                        <h1 class="text-2xl font-semibold text-gray-900 my-auto"><?php echo $__env->yieldContent('page-heading'); ?></h1>
                    </div>
                    <div class="flex items-center ml-4 md:ml-6">
                        <div class="relative ml-3">
                            <div>
                                <button class="flex items-center max-w-xs text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button">
                                    <span class="mr-2 text-gray-700"><?php echo e(auth()->user()->name); ?></span>
                                    <i class="text-gray-400 fas fa-chevron-down"></i>
                                </button>
                            </div>
                            <div id="user-menu" class="absolute right-0 hidden w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5">
                                <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Sign out
                                </a>
                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="hidden">
                                    <?php echo csrf_field(); ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <main class="relative flex-1 overflow-y-auto focus:outline-none p-6">
                <?php if(session('success')): ?>
                    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                        <p><?php echo e(session('success')); ?></p>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                        <p><?php echo e(session('error')); ?></p>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <script>
        // Sidebar toggle (mobile)
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.querySelector('.md\\:flex-shrink-0');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('md:flex');
            });
        }

        // User menu toggle
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        if (userMenuButton && userMenu) {
            userMenuButton.addEventListener('click', () => {
                userMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                    userMenu.classList.add('hidden');
                }
            });
        }
    </script>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\Tu5k\study\php\Carrio-Motors\Carrio-Motors\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>