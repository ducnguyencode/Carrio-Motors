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

    <style>
        /* Custom styles */
        input[type="color"] {
            -webkit-appearance: none;
            border: none;
        }
        input[type="color"]::-webkit-color-swatch-wrapper {
            padding: 0;
        }
        input[type="color"]::-webkit-color-swatch {
            border: none;
            border-radius: 4px 0 0 4px;
        }

        /* Better form input styles */
        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        /* Improve color picker */
        .color-picker-wrapper input[type="color"] {
            height: 48px;
            border-radius: 6px 0 0 6px;
        }

        /* Animated transitions */
        .transition-all {
            transition: all 0.2s ease-in-out;
        }

        /* @apply directive styles for blog pages */
        .bg-white {
            background-color: white;
        }
        .rounded-lg {
            border-radius: 0.5rem;
        }
        .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .overflow-hidden {
            overflow: hidden;
        }
        .mb-5 {
            margin-bottom: 1.25rem;
        }
        .px-5 {
            padding-left: 1.25rem;
            padding-right: 1.25rem;
        }
        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        .border-b {
            border-bottom-width: 1px;
        }
        .border-gray-100 {
            border-color: rgba(243, 244, 246, 1);
        }
        .flex {
            display: flex;
        }
        .items-center {
            align-items: center;
        }
        .p-5 {
            padding: 1.25rem;
        }
        .block {
            display: block;
        }
        .text-sm {
            font-size: 0.875rem;
        }
        .font-medium {
            font-weight: 500;
        }
        .text-gray-700 {
            color: rgba(55, 65, 81, 1);
        }
        .mb-1 {
            margin-bottom: 0.25rem;
        }
        .w-full {
            width: 100%;
        }
        .rounded-md {
            border-radius: 0.375rem;
        }
        .border-gray-300 {
            border-color: rgba(209, 213, 219, 1);
        }
        .focus\:border-blue-500:focus {
            border-color: rgba(59, 130, 246, 1);
        }
        .focus\:ring:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        }
        .focus\:ring-blue-200:focus {
            box-shadow: 0 0 0 3px rgba(191, 219, 254, 0.5);
        }
        .focus\:ring-opacity-50:focus {
            --tw-ring-opacity: 0.5;
        }
        .text-lg {
            font-size: 1.125rem;
        }
        .font-medium {
            font-weight: 500;
        }
        .mr-2 {
            margin-right: 0.5rem;
        }
        .text-blue-500 {
            color: rgba(59, 130, 246, 1);
        }
        .w-5 {
            width: 1.25rem;
        }
        .h-5 {
            height: 1.25rem;
        }
        .flex-shrink-0 {
            flex-shrink: 0;
        }
        .mt-1 {
            margin-top: 0.25rem;
        }
        .justify-center {
            justify-content: center;
        }
        .pt-5 {
            padding-top: 1.25rem;
        }
        .pb-6 {
            padding-bottom: 1.5rem;
        }
        .border-2 {
            border-width: 2px;
        }
        .border-gray-300 {
            border-color: rgba(209, 213, 219, 1);
        }
        .border-dashed {
            border-style: dashed;
        }
        .cursor-pointer {
            cursor: pointer;
        }
        .hover\:bg-gray-50:hover {
            background-color: rgba(249, 250, 251, 1);
        }
        .transition-colors {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
        .flex-wrap {
            flex-wrap: wrap;
        }
        .gap-2 {
            gap: 0.5rem;
        }
        .mt-2 {
            margin-top: 0.5rem;
        }
        .bg-gray-100 {
            background-color: rgba(243, 244, 246, 1);
        }
        .text-gray-800 {
            color: rgba(31, 41, 55, 1);
        }
        .text-xs {
            font-size: 0.75rem;
        }
        .rounded-full {
            border-radius: 9999px;
        }
        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        .py-1 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }
        .ml-2 {
            margin-left: 0.5rem;
        }
        .text-gray-500 {
            color: rgba(107, 114, 128, 1);
        }
        .hover\:text-red-500:hover {
            color: rgba(239, 68, 68, 1);
        }
        .bg-blue-600 {
            background-color: rgba(37, 99, 235, 1);
        }
        .hover\:bg-blue-700:hover {
            background-color: rgba(29, 78, 216, 1);
        }
        .text-white {
            color: rgba(255, 255, 255, 1);
        }
        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .bg-white {
            background-color: rgba(255, 255, 255, 1);
        }
        .border {
            border-width: 1px;
        }
        .text-gray-700 {
            color: rgba(55, 65, 81, 1);
        }
        .hover\:bg-gray-50:hover {
            background-color: rgba(249, 250, 251, 1);
        }
        .justify-between {
            justify-content: space-between;
        }
        .space-x-2 > :not([hidden]) ~ :not([hidden]) {
            --tw-space-x-reverse: 0;
            margin-right: calc(0.5rem * var(--tw-space-x-reverse));
            margin-left: calc(0.5rem * calc(1 - var(--tw-space-x-reverse)));
        }
        .mt-6 {
            margin-top: 1.5rem;
        }
        .flex-1 {
            flex: 1 1 0%;
        }
        .text-center {
            text-align: center;
        }
    </style>

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
                        <?php endif; ?>
                        <?php if(auth()->user()->role === 'admin' || auth()->user()->role === 'content'): ?>
                        <?php if(auth()->user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700 <?php echo e(request()->routeIs('admin.users*') ? 'bg-gray-700' : ''); ?>">
                            <i class="mr-3 text-lg fas fa-users"></i>
                            Users
                        </a>
                        <a href="<?php echo e(route('admin.activity-logs.index')); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700 <?php echo e(request()->routeIs('admin.activity-logs*') ? 'bg-gray-700' : ''); ?>">
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
                        <?php if(auth()->user()->role === 'admin' || auth()->user()->role === 'content'): ?>
                        <a href="<?php echo e(route('admin.blog.index')); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white <?php echo e(request()->routeIs('admin.blog*') ? 'bg-gray-700' : ''); ?>">
                            <i class="mr-3 text-lg fas fa-newspaper"></i>
                            Blog
                        </a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('admin.banners.index')); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                            <i class="mr-3 text-lg fas fa-images"></i>
                            Banners
                        </a>
                        <?php endif; ?>

                        <?php if(auth()->user()->role === 'admin' || auth()->user()->role === 'saler'): ?>
                        <?php if(auth()->user()->role === 'admin'): ?>
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
                        <a href="<?php echo e(route('user.purchases')); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
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
                        <div class="flex items-center">
                            <span class="mr-2 text-gray-700"><?php echo e(auth()->user()->name); ?></span>
                            <span class="px-2 py-1 text-xs font-medium text-gray-600 bg-gray-200 rounded-full"><?php echo e(auth()->user()->role); ?></span>
                        </div>

                        <!-- Modern Sign Out Button -->
                        <a href="<?php echo e(route('logout')); ?>"
                           onclick="event.preventDefault(); document.getElementById('logout-form-2').submit();"
                           class="inline-flex items-center px-3 py-2 ml-3 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <i class="mr-2 fas fa-sign-out-alt"></i>
                            Sign Out
                        </a>
                        <form id="logout-form-2" action="<?php echo e(route('logout')); ?>" method="POST" class="hidden">
                            <?php echo csrf_field(); ?>
                        </form>
                    </div>
                </div>
            </div>

            <main class="relative flex-1 overflow-y-auto focus:outline-none p-6">
                <?php if(session('success') && !isset($hideFlashMessages) && !request()->routeIs('admin.blog*')): ?>
                    <div class="mb-4 p-3 bg-green-100 border-l-4 border-green-500 text-green-700 rounded flex justify-between items-center">
                        <span><?php echo e(session('success')); ?></span>
                        <button onclick="this.parentElement.style.display='none'" class="ml-4 text-green-700 hover:text-green-900">&times;</button>
                    </div>
                <?php endif; ?>

                <?php if(session('error') && !isset($hideFlashMessages) && !request()->routeIs('admin.blog*')): ?>
                    <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 rounded flex justify-between items-center">
                        <span><?php echo e(session('error')); ?></span>
                        <button onclick="this.parentElement.style.display='none'" class="ml-4 text-red-700 hover:text-red-900">&times;</button>
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
    </script>

    <?php echo $__env->yieldContent('scripts'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /Applications/XAMPP/Carrio-Motors/resources/views/admin/layouts/app.blade.php ENDPATH**/ ?>