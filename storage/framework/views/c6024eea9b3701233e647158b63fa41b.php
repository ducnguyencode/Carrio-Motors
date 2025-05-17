<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="mb-4">Featured Cars</h2>
    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100" onclick="window.location.href='<?php echo e(route('car.detail', ['id' => $car->id])); ?>'">
                <img src="<?php echo e($car->image_url); ?>" class="card-img-top" style="height: 180px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo e($car->name); ?></h5>
                    <div class="text-warning mb-2">
                        <?php echo e(number_format($car->rating, 1)); ?> ⭐ (<?php echo e($car->reviews); ?> reviews)
                    </div>
                    <?php if($car->is_best_seller): ?>
                        <span class="badge bg-success">Best Seller</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p>No featured cars found.</p>
        <?php endif; ?>
    </div>

    <div class="mt-4">
        <?php echo e($cars->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\521H0251_NguyenVanKhoa\Aptech\Project_T1\New folder\Carrio-Motors\resources\views/featured-cars.blade.php ENDPATH**/ ?>