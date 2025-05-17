<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Trashed Invoices</h1>
        <a href="<?php echo e(route('admin.invoices.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Invoices
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer Info</th>
                            <th>Purchase Date</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Deleted At</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $trashedInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($invoice->id); ?></td>
                                <td>
                                    <strong><?php echo e($invoice->customer_name); ?></strong><br>
                                    <small><i class="fas fa-envelope"></i> <?php echo e($invoice->customer_email); ?></small><br>
                                    <small><i class="fas fa-phone"></i> <?php echo e($invoice->customer_phone); ?></small>
                                </td>
                                <td><?php echo e(\Carbon\Carbon::parse($invoice->purchase_date)->format('Y-m-d H:i')); ?></td>
                                <td>$<?php echo e(number_format($invoice->total_price, 2)); ?></td>
                                <td>
                                    <?php
                                        $statusClass = match($invoice->status) {
                                            'pending' => 'warning',
                                            'recheck' => 'info',
                                            'done' => 'success',
                                            'cancel' => 'danger',
                                            default => 'secondary'
                                        };
                                    ?>
                                    <span class="badge bg-<?php echo e($statusClass); ?>">
                                        <?php echo e(ucfirst($invoice->status)); ?>

                                    </span>
                                </td>
                                <td><?php echo e($invoice->deleted_at->format('Y-m-d H:i')); ?></td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <form action="<?php echo e(route('admin.invoices.restore', $invoice->id)); ?>"
                                              method="POST"
                                              class="restore-form">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit"
                                                    class="btn btn-success btn-sm"
                                                    data-bs-toggle="tooltip"
                                                    title="Restore Invoice">
                                                <i class="fas fa-trash-restore"></i>
                                            </button>
                                        </form>
                                        <form action="<?php echo e(route('admin.invoices.force-delete', $invoice->id)); ?>"
                                              method="POST"
                                              class="force-delete-form">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    data-bs-toggle="tooltip"
                                                    title="Permanently Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center">No trashed invoices found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                <?php echo e($trashedInvoices->links()); ?>

            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Handle restore confirmation
    $('.restore-form').on('submit', function(e) {
        e.preventDefault();
        var form = this;

        Swal.fire({
            title: 'Restore Invoice?',
            text: "The invoice will be restored and visible in the main list.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, restore it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Handle permanent delete confirmation
    $('.force-delete-form').on('submit', function(e) {
        e.preventDefault();
        var form = this;

        Swal.fire({
            title: 'Delete Permanently?',
            text: "You won't be able to recover this invoice!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete permanently!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Tu5k\study\php\Carrio-Motors-clone\Carrio-Motors\resources\views/admin/invoices/trash.blade.php ENDPATH**/ ?>