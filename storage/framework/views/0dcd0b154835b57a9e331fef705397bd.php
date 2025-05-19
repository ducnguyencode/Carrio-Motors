<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="alert alert-success mt-4" role="alert">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>
<div class="video-carousel">
    <div class="carousel-slide active">
        <video class="background-video" autoplay muted loop playsinline>
            <source src="<?php echo e(asset('videos/video1.mp4')); ?>" type="video/mp4">
        </video>
        <div class="carousel-content">
            <h1>Car 1</h1>
            <h4>Luxury meets performance</h4>
        </div>
    </div>
    <div class="carousel-slide">
        <video class="background-video" autoplay muted loop playsinline>
            <source src="<?php echo e(asset('videos/video2.mp4')); ?>" type="video/mp4">
        </video>
        <div class="carousel-content">
            <h1>Car 2</h1>
            <h4>Style and speed combined</h4>
        </div>
    </div>
    <div class="carousel-slide">
        <video class="background-video" autoplay muted loop playsinline>
            <source src="<?php echo e(asset('videos/video3.mp4')); ?>" type="video/mp4">
        </video>
        <div class="carousel-content">
            <h1>Car 3</h1>
            <h4>Innovation on wheels</h4>
        </div>
    </div>

    <div class="carousel-indicators">
        <div class="dot active"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
</div>

<h1 class="mt-5">Welcome to Carrio Motors</h1>
<p>Explore top brands like BMW, Audi, Hyundai, JEEP, Suzuki, and more!</p>
<img src="/images/banner.jpg" alt="Car Banner" class="img-fluid">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Project\Carrio-Motors\resources\views/home.blade.php ENDPATH**/ ?>