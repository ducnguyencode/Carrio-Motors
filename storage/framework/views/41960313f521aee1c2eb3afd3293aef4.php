<?php $__env->startSection('styles'); ?>
<style>
    .video-link {
        display: block;
        width: 100%;
        height: 100%;
        text-decoration: none;
        color: inherit;
        cursor: pointer;
    }

    .video-link:hover .carousel-content {
        text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="alert alert-success mt-4" role="alert">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>
<div class="video-carousel">
    <?php $__empty_1 = true; $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="carousel-slide <?php echo e($index === 0 ? 'active' : ''); ?>">
        <a href="<?php echo e($banner->click_url ?? ($banner->car_id ? route('cars', ['id' => $banner->car_id]) : '#')); ?>" class="video-link">
            <video class="background-video" autoplay muted loop playsinline>
                <source src="<?php echo e(Storage::url($banner->video_url)); ?>" type="video/mp4">
            </video>
            <div class="carousel-content">
                <h1><?php echo e($banner->title); ?></h1>
                <h4><?php echo e($banner->main_content); ?></h4>
            </div>
        </a>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <!-- Fallback to default videos if no banners in database -->
    <div class="carousel-slide active">
        <a href="#" class="video-link">
            <video class="background-video" autoplay muted loop playsinline>
                <source src="<?php echo e(asset('videos/video1.mp4')); ?>" type="video/mp4">
            </video>
            <div class="carousel-content">
                <h1>Car 1</h1>
                <h4>Luxury meets performance</h4>
            </div>
        </a>
    </div>
    <div class="carousel-slide">
        <a href="#" class="video-link">
            <video class="background-video" autoplay muted loop playsinline>
                <source src="<?php echo e(asset('videos/video2.mp4')); ?>" type="video/mp4">
            </video>
            <div class="carousel-content">
                <h1>Car 2</h1>
                <h4>Style and speed combined</h4>
            </div>
        </a>
    </div>
    <div class="carousel-slide">
        <a href="#" class="video-link">
            <video class="background-video" autoplay muted loop playsinline>
                <source src="<?php echo e(asset('videos/video3.mp4')); ?>" type="video/mp4">
            </video>
            <div class="carousel-content">
                <h1>Car 3</h1>
                <h4>Innovation on wheels</h4>
            </div>
        </a>
    </div>
    <?php endif; ?>

    <div class="carousel-indicators">
        <?php if($banners->count() > 0): ?>
            <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="dot <?php echo e($index === 0 ? 'active' : ''); ?>"></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="dot active"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        <?php endif; ?>
    </div>
</div>

<h1 class="mt-5">Welcome to Carrio Motors</h1>
<p>Explore top brands like BMW, Audi, Hyundai, JEEP, Suzuki, and more!</p>
<img src="/images/banner.jpg" alt="Car Banner" class="img-fluid">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/Carrio-Motors/resources/views/home.blade.php ENDPATH**/ ?>