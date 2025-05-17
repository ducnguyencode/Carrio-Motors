<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Invoice #<?php echo e($invoice->id); ?></h1>
        <a href="<?php echo e(route('admin.invoices.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?php echo e(route('admin.invoices.update', $invoice)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row">
                    <!-- Customer Information -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Customer Information</h5>
                        <div class="form-group">
                            <label for="customer_name">Customer Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name"
                                   value="<?php echo e(old('customer_name', $invoice->customer_name)); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="customer_email">Customer Email</label>
                            <input type="email" class="form-control" id="customer_email" name="customer_email"
                                   value="<?php echo e(old('customer_email', $invoice->customer_email)); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="customer_phone">Customer Phone</label>
                            <input type="text" class="form-control" id="customer_phone" name="customer_phone"
                                   value="<?php echo e(old('customer_phone', $invoice->customer_phone)); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="customer_address">Customer Address</label>
                            <textarea class="form-control" id="customer_address" name="customer_address"
                                      rows="3" required><?php echo e(old('customer_address', $invoice->customer_address)); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="payment_method">Payment Method</label>
                            <select class="form-control" id="payment_method" name="payment_method" required>
                                <option value="cash" <?php echo e($invoice->payment_method === 'cash' ? 'selected' : ''); ?>>Cash</option>
                                <option value="bank_transfer" <?php echo e($invoice->payment_method === 'bank_transfer' ? 'selected' : ''); ?>>Bank Transfer</option>
                                <option value="credit_card" <?php echo e($invoice->payment_method === 'credit_card' ? 'selected' : ''); ?>>Credit Card</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e(strtolower($key)); ?>" <?php echo e(strtolower(old('status', $invoice->status)) === strtolower($key) ? 'selected' : ''); ?>>
                                        <?php echo e($value); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <!-- Invoice Details -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Invoice Details</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Car</th>
                                        <th>Color</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $invoice->invoiceDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <?php echo e($detail->carDetail->car->name); ?>

                                                <input type="hidden" name="invoice_details[<?php echo e($loop->index); ?>][id]" value="<?php echo e($detail->id); ?>">
                                            </td>
                                            <td><?php echo e($detail->carDetail->carColor->name); ?></td>
                                            <td><?php echo e(number_format($detail->price, 2)); ?></td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm quantity-input"
                                                       name="invoice_details[<?php echo e($loop->index); ?>][quantity]"
                                                       value="<?php echo e($detail->quantity); ?>"
                                                       min="1"
                                                       max="<?php echo e($detail->carDetail->quantity + $detail->quantity); ?>"
                                                       data-price="<?php echo e($detail->price); ?>"
                                                       required>
                                            </td>
                                            <td class="item-total"><?php echo e(number_format($detail->price * $detail->quantity, 2)); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right"><strong>Total:</strong></td>
                                        <td id="grand-total"><?php echo e(number_format($invoice->total_price, 2)); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Invoice
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInputs = document.querySelectorAll('.quantity-input');
        const grandTotalElement = document.getElementById('grand-total');

        function updateTotals() {
            let grandTotal = 0;

            quantityInputs.forEach(input => {
                const price = parseFloat(input.dataset.price);
                const quantity = parseInt(input.value);
                const total = price * quantity;

                // Update row total
                const row = input.closest('tr');
                row.querySelector('.item-total').textContent = total.toFixed(2);

                grandTotal += total;
            });

            // Update grand total
            grandTotalElement.textContent = grandTotal.toFixed(2);
        }

        quantityInputs.forEach(input => {
            input.addEventListener('change', updateTotals);
            input.addEventListener('input', updateTotals);
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Tu5k\study\php\Carrio-Motors-clone\Carrio-Motors\resources\views/admin/invoices/edit.blade.php ENDPATH**/ ?>