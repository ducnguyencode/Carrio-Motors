<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Create New Invoice</h6>
            <a href="<?php echo e(route('admin.invoices.index')); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
        <div class="card-body">
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('admin.invoices.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <!-- Customer Information -->
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3">Customer Information</h5>
                        <div class="form-group mb-3">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="customer_name" name="customer_name" value="<?php echo e(old('customer_name')); ?>" required>
                            <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="customer_email" class="form-label">Customer Email</label>
                            <input type="email" class="form-control <?php $__errorArgs = ['customer_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="customer_email" name="customer_email" value="<?php echo e(old('customer_email')); ?>" required>
                            <?php $__errorArgs = ['customer_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="customer_phone" class="form-label">Customer Phone</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="customer_phone" name="customer_phone" value="<?php echo e(old('customer_phone')); ?>" required>
                            <?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="customer_address" class="form-label">Customer Address</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['customer_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="customer_address" name="customer_address" value="<?php echo e(old('customer_address')); ?>" required>
                            <?php $__errorArgs = ['customer_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-control <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="payment_method" name="payment_method" required>
                                <option value="">Select Payment Method</option>
                                <option value="cash" <?php echo e(old('payment_method') == 'cash' ? 'selected' : ''); ?>>Cash</option>
                                <option value="bank_transfer" <?php echo e(old('payment_method') == 'bank_transfer' ? 'selected' : ''); ?>>Bank Transfer</option>
                                <option value="credit_card" <?php echo e(old('payment_method') == 'credit_card' ? 'selected' : ''); ?>>Credit Card</option>
                            </select>
                            <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <!-- Car Selection -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Car Selection</h5>
                        <div id="carSelections">
                            <div class="car-selection mb-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Select Car</label>
                                    <div class="input-group">
                                        <select class="form-control car-select <?php $__errorArgs = ['car_detail_ids.0'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            name="car_detail_ids[]" required>
                                            <option value="">Select a Car</option>
                                            <?php $__currentLoopData = $carDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($carDetail->id); ?>"
                                                    data-price="<?php echo e($carDetail->price); ?>"
                                                    data-max="<?php echo e($carDetail->quantity); ?>"
                                                    <?php echo e(old('car_detail_ids.0') == $carDetail->id ? 'selected' : ''); ?>>
                                                    <?php echo e($carDetail->car_name); ?> -
                                                    <?php echo e($carDetail->model_name); ?> -
                                                    <?php echo e($carDetail->engine_name); ?> -
                                                    <?php echo e($carDetail->color_name); ?> -
                                                    $<?php echo e(number_format($carDetail->price, 2)); ?>

                                                    (<?php echo e($carDetail->quantity); ?> available)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <button type="button" class="btn btn-danger remove-car" style="display: none;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <?php $__errorArgs = ['car_detail_ids.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" class="form-control quantity-input <?php $__errorArgs = ['quantities.0'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="quantities[]" min="1" value="<?php echo e(old('quantities.0', 1)); ?>" required>
                                    <?php $__errorArgs = ['quantities.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" id="addCarBtn">
                            <i class="fas fa-plus"></i> Add Another Car
                        </button>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Invoice
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        // Show/hide remove button
        function updateRemoveButtons() {
            const selections = $('.car-selection');
            if (selections.length > 1) {
                $('.remove-car').show();
            } else {
                $('.remove-car').hide();
            }
        }

        // Add new car selection
        $('#addCarBtn').click(function() {
            const newSelection = $('.car-selection').first().clone();

            // Reset values
            newSelection.find('select').val('');
            newSelection.find('.quantity-input').val(1);

            // Show remove button
            newSelection.find('.remove-car').show();

            $('#carSelections').append(newSelection);
            updateRemoveButtons();
        });

        // Remove car selection
        $(document).on('click', '.remove-car', function() {
            $(this).closest('.car-selection').remove();
            updateRemoveButtons();
        });

        // Update quantity max based on available stock
        $(document).on('change', '.car-select', function() {
            const selected = $(this).find(':selected');
            const maxQuantity = selected.data('max');
            const container = $(this).closest('.car-selection');
            const quantityInput = container.find('.quantity-input');

            if (selected.val()) {
                quantityInput.attr('max', maxQuantity);
                if (parseInt(quantityInput.val()) > maxQuantity) {
                    quantityInput.val(maxQuantity);
                }
            } else {
                quantityInput.attr('max', '');
            }
        });

        // Initialize max quantities for pre-selected cars
        $('.car-select').each(function() {
            if ($(this).val()) {
                $(this).trigger('change');
            }
        });

        // Form validation before submit
        $('form').on('submit', function(e) {
            let isValid = true;

            // Check if at least one car is selected
            $('.car-select').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    $(this).next('.invalid-feedback').text('Please select a car');
                    isValid = false;
                }
            });

            // Check quantities
            $('.quantity-input').each(function() {
                const val = parseInt($(this).val());
                const max = parseInt($(this).attr('max'));

                if (!val || val < 1) {
                    $(this).addClass('is-invalid');
                    $(this).next('.invalid-feedback').text('Quantity must be at least 1');
                    isValid = false;
                } else if (max && val > max) {
                    $(this).addClass('is-invalid');
                    $(this).next('.invalid-feedback').text(`Maximum quantity is ${max}`);
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Tu5k\study\php\Carrio-Motors-clone\Carrio-Motors\resources\views/admin/invoices/create.blade.php ENDPATH**/ ?>