<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Invoice #<?php echo e($invoice->id); ?></h1>
        <div>
            <a href="<?php echo e(route('admin.invoices.edit', $invoice)); ?>" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Invoice
            </a>
            <a href="<?php echo e(route('admin.invoices.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Customer Information -->
        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Name:</strong>
                        <p class="mb-0"><?php echo e($invoice->customer_name); ?></p>
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong>
                        <p class="mb-0"><?php echo e($invoice->customer_email); ?></p>
                    </div>
                    <div class="mb-3">
                        <strong>Phone:</strong>
                        <p class="mb-0"><?php echo e($invoice->customer_phone); ?></p>
                    </div>
                    <div class="mb-3">
                        <strong>Address:</strong>
                        <p class="mb-0"><?php echo e($invoice->customer_address); ?></p>
                    </div>
                    <div class="mb-3">
                        <strong>Payment Method:</strong>
                        <p class="mb-0"><?php echo e(ucfirst($invoice->payment_method)); ?></p>
                    </div>
                    <div class="mb-3">
                        <strong>Status:</strong>
                        <span class="badge bg-<?php echo e($invoice->status === 'pending' ? 'warning' : ($invoice->status === 'done' ? 'success' : 'danger')); ?>">
                            <?php echo e(ucfirst($invoice->status)); ?>

                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Invoice Details</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Car</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $invoice->invoiceDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($detail->carDetail->car->name); ?></td>
                                        <td><?php echo e($detail->carDetail->carColor->name); ?></td>
                                        <td><?php echo e($detail->quantity); ?></td>
                                        <td>$<?php echo e(number_format($detail->price, 2)); ?></td>
                                        <td>$<?php echo e(number_format($detail->price * $detail->quantity, 2)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Total:</th>
                                    <th>$<?php echo e(number_format($invoice->total_price, 2)); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Tu5k\study\php\Carrio-Motors-clone\Carrio-Motors\resources\views/admin/invoices/show.blade.php ENDPATH**/ ?>