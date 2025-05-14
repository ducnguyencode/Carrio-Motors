<?php $__env->startSection('content'); ?>
<h2>Available Cars</h2>
<div class="row">
    <?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-4 mb-4">
        <div class="card">
            <img src="<?php echo e($car->image_url); ?>" class="card-img-top" alt="<?php echo e($car->name); ?>">
            <div class="card-body">
                <h5 class="card-title"><?php echo e($car->name); ?></h5>
                <p class="card-text">Brand: <?php echo e($car->brand); ?> | Seats: <?php echo e($car->seat_number); ?></p>
                <a href="/cars/<?php echo e($car->id); ?>" class="btn btn-primary">View Details</a>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/Carrio-Motors/resources/views/cars.blade.php ENDPATH**/ ?>