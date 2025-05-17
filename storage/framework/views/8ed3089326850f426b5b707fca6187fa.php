<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Invoices</h1>
        <div>
            <?php if(Auth::user()->role === 'admin'): ?>
            <a href="<?php echo e(route('admin.invoices.trash')); ?>" class="btn btn-secondary">
                <i class="fas fa-trash"></i> Trash
            </a>
            <?php endif; ?>
            <a href="<?php echo e(route('admin.invoices.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Invoice
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <form action="<?php echo e(route('admin.invoices.index')); ?>" method="GET" class="d-flex align-items-center" id="searchForm">
                        <div class="input-group mr-3" style="width: 300px;">
                            <input type="text" name="search" class="form-control" placeholder="Search by name or phone..." value="<?php echo e(request('search')); ?>">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>

                        <select name="status" class="form-control mr-3" style="width: 150px;" onchange="document.getElementById('searchForm').submit()">
                            <option value="">All Status</option>
                            <?php $__currentLoopData = \App\Models\Invoice::getStatuses(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php echo e(request('status') == $value ? 'selected' : ''); ?>>
                                    <?php echo e($label); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </form>

                    <?php if(request('search') || request('status')): ?>
                        <a href="<?php echo e(route('admin.invoices.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear Filters
                        </a>
                    <?php endif; ?>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer Info</th>
                            <th>Purchase Date</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($invoice->id); ?></td>
                                <td>
                                    <strong><?php echo e($invoice->customer_name); ?></strong><br>
                                    <small>
                                        <i class="fas fa-envelope"></i> <?php echo e($invoice->customer_email); ?><br>
                                        <i class="fas fa-phone"></i> <?php echo e($invoice->customer_phone); ?>

                                    </small>
                                </td>
                                <td><?php echo e($invoice->purchase_date->format('Y-m-d H:i')); ?></td>
                                <td>$<?php echo e(number_format($invoice->total_price, 2)); ?></td>
                                <td>
                                    <?php
                                        $statusClass = match(strtolower($invoice->status)) {
                                            'pending' => 'warning',
                                            'recheck' => 'info',
                                            'done' => 'success',
                                            'cancel' => 'danger',
                                            default => 'secondary'
                                        };
                                    ?>
                                    <span class="badge bg-<?php echo e($statusClass); ?>">
                                        <?php echo e(ucfirst($invoice->status ?? 'N/A')); ?>

                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('admin.invoices.show', $invoice->id)); ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.invoices.edit', $invoice->id)); ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.invoices.destroy', $invoice->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to move this invoice to trash?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center">No invoices found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing <?php echo e($invoices->firstItem() ?? 0); ?> to <?php echo e($invoices->lastItem() ?? 0); ?> of <?php echo e($invoices->total()); ?> results
                    </div>
                    <div class="d-flex">
                        <?php if($invoices->previousPageUrl()): ?>
                            <a href="<?php echo e($invoices->previousPageUrl()); ?>" class="btn btn-outline-primary mr-2">
                                <i class="fas fa-chevron-left"></i> Previous
                            </a>
                        <?php else: ?>
                            <button class="btn btn-outline-primary mr-2" disabled>
                                <i class="fas fa-chevron-left"></i> Previous
                            </button>
                        <?php endif; ?>

                        <?php if($invoices->nextPageUrl()): ?>
                            <a href="<?php echo e($invoices->nextPageUrl()); ?>" class="btn btn-outline-primary">
                                Next <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php else: ?>
                            <button class="btn btn-outline-primary" disabled>
                                Next <i class="fas fa-chevron-right"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Tu5k\study\php\Carrio-Motors-clone\Carrio-Motors\resources\views/admin/invoices/index.blade.php ENDPATH**/ ?>