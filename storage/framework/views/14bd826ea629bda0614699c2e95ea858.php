<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo e(route('admin.dashboard')); ?>">
            <i class="fas fa-car"></i> Carrio Motors
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <?php if(auth()->user()->role === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.users.index')); ?>">
                        <i class="fas fa-users"></i> Users
                    </a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.cars.*') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.cars.index')); ?>">
                        <i class="fas fa-car"></i> Cars
                    </a>
                </li>
                <?php if(in_array(auth()->user()->role, ['admin', 'saler'])): ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.invoices.*') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.invoices.index')); ?>">
                        <i class="fas fa-file-invoice-dollar"></i> Invoices
                    </a>
                </li>
                <?php endif; ?>
                <?php if(in_array(auth()->user()->role, ['admin', 'content'])): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo e(request()->routeIs(['admin.makes.*', 'admin.models.*', 'admin.engines.*', 'admin.car_colors.*']) ? 'active' : ''); ?>"
                       href="#" id="navbarDropdownCatalog" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-book"></i> Catalog
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item <?php echo e(request()->routeIs('admin.makes.*') ? 'active' : ''); ?>"
                               href="<?php echo e(route('admin.makes.index')); ?>">
                                <i class="fas fa-industry"></i> Makes
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?php echo e(request()->routeIs('admin.models.*') ? 'active' : ''); ?>"
                               href="<?php echo e(route('admin.models.index')); ?>">
                                <i class="fas fa-car-side"></i> Models
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?php echo e(request()->routeIs('admin.engines.*') ? 'active' : ''); ?>"
                               href="<?php echo e(route('admin.engines.index')); ?>">
                                <i class="fas fa-cogs"></i> Engines
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?php echo e(request()->routeIs('admin.car_colors.*') ? 'active' : ''); ?>"
                               href="<?php echo e(route('admin.car_colors.index')); ?>">
                                <i class="fas fa-palette"></i> Colors
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.banners.*') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.banners.index')); ?>">
                        <i class="fas fa-images"></i> Banners
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user"></i> <?php echo e(auth()->user()->username); ?>

                        <span class="badge bg-primary"><?php echo e(ucfirst(auth()->user()->role)); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
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
<?php /**PATH C:\Users\Tu5k\study\php\Carrio-Motors-clone\Carrio-Motors\resources\views/admin/layouts/navigation.blade.php ENDPATH**/ ?>