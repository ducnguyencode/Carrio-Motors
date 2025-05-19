<?php $__env->startSection('content'); ?>
<h2>Buy a Car</h2>
<form method="POST" action="/buy/submit">
    <?php echo csrf_field(); ?>
    <div class="mb-3">
        <label>Your Name</label>
        <input type="text" name="customer_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="customer_email" class="form-control">
    </div>
    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="customer_phone" class="form-control">
    </div>
    <div class="mb-3">
        <label>Car</label>
        <select name="car_detail_id" class="form-control">
            <?php $__currentLoopData = $carDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($cd->id); ?>"><?php echo e($cd->car->name); ?> - <?php echo e($cd->color->color_name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Quantity</label>
        <input type="number" name="quantity" class="form-control" value="1" min="1">
    </div>
    <div class="mb-3">
        <label>Payment Method</label>
        <select name="payment_method" class="form-control">
            <option value="Cash">Cash</option>
            <option value="Bank Transfer">Bank Transfer</option>
            <option value="Installment">Installment</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\521H0251_NguyenVanKhoa\Aptech\Project_T1\New folder\Carrio-Motors\resources\views/buy.blade.php ENDPATH**/ ?>