<?php $__env->startSection('title', 'My Dashboard'); ?>
<?php $__env->startSection('page-heading', 'My Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <div class="card shadow p-4">
                <h2 class="mb-3">Welcome, <?php echo e($user->fullname ?? $user->name); ?></h2>
                <p><strong>Email:</strong> <?php echo e($user->email); ?></p>
                <p><strong>Phone:</strong> <?php echo e($user->phone); ?></p>
                <p><strong>Address:</strong> <?php echo e($user->address); ?></p>
                <p><strong>Email Verified:</strong> <?php echo $user->hasVerifiedEmail() ? '<span class="badge bg-success">Verified</span>' : '<span class="badge bg-warning text-dark">Not Verified</span>'; ?></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card shadow p-4">
                <h3 class="mb-3">My Invoices</h3>
                <?php if($invoices->count()): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>#<?php echo e($invoice->id); ?></td>
                                        <td><?php echo e($invoice->created_at->format('d/m/Y')); ?></td>
                                        <td>
                                            <?php if($invoice->process_status == 'deposit'): ?>
                                                <span class="badge bg-warning text-dark">Deposit</span>
                                            <?php elseif($invoice->process_status == 'payment'): ?>
                                                <span class="badge bg-info text-dark">Payment</span>
                                            <?php elseif($invoice->process_status == 'warehouse'): ?>
                                                <span class="badge bg-primary">Warehouse</span>
                                            <?php elseif($invoice->process_status == 'success'): ?>
                                                <span class="badge bg-success">Success</span>
                                            <?php elseif($invoice->process_status == 'cancel'): ?>
                                                <span class="badge bg-danger">Cancel</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(number_format($invoice->total_price, 0, ',', '.')); ?> $</td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">You have no invoices yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/Carrio-Motors/resources/views/user/dashboard.blade.php ENDPATH**/ ?>