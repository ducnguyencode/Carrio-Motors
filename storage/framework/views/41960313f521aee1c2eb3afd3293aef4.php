<?php $__env->startSection('styles'); ?>
<style>
    .video-link {
        display: block;
        width: 100%;
        height: 100%;
        text-decoration: none;
        color: inherit;
        cursor: pointer;
        position: relative;
    }

    .video-link:hover .carousel-content {
        text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
    }

    .carousel-slide {
        position: relative;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="alert alert-success mt-4" role="alert">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<?php if(count($banners) > 0): ?>
<div class="video-carousel">
    <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="carousel-slide <?php echo e($index == 0 ? 'active' : ''); ?>">
        <a href="<?php echo e($banner->click_url ?? '#'); ?>" class="video-link">
            <video class="background-video" autoplay muted loop>
                <source src="<?php echo e(asset('storage/'.$banner->video_url)); ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="carousel-content">
                <h4><?php echo e($banner->subtitle); ?></h4>
                <h1><?php echo e($banner->title); ?></h1>
            </div>
        </a>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="carousel-indicators">
        <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="dot <?php echo e($index == 0 ? 'active' : ''); ?>"></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>

<div class="container main-content">
    <div class="row">
        <div class="col-md-12">
            <h1 class="display-4 mb-4">Welcome to Carrio Motors</h1>
            <p class="lead">Explore top brands like BMW, Audi, Hyundai, JEEP, Suzuki, and more!</p>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <img src="<?php echo e(asset('images/car-banner.jpg')); ?>" class="img-fluid rounded shadow-sm" alt="Car Banner">
        </div>
    </div>

    <section class="featured-cars">
        <h2 class="text-center mb-5">Featured Cars</h2>
        <div class="row g-4">
            <?php $__currentLoopData = $featuredCars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <img src="<?php echo e($car['image_url']); ?>" class="card-img-top" alt="<?php echo e($car['name']); ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($car['name']); ?></h5>
                        <div class="d-flex align-items-center mb-2">
                            <span class="text-warning me-1"><?php echo e($car['rating']); ?></span>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="text-muted ms-1">(<?php echo e($car['reviews']); ?> reviews)</span>
                        </div>
                        <div class="mb-3">
                            <span class="fw-bold">$<?php echo e(number_format($car['price'])); ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="badge bg-success"><?php echo e($car['engine']); ?></span>
                            <span class="badge bg-secondary"><?php echo e($car['fuel_type']); ?></span>
                            <span class="badge bg-info"><?php echo e($car['transmission']); ?></span>
                        </div>
                        <?php if($car['is_best_seller']): ?>
                        <div class="text-center mb-3">
                            <span class="bg-success text-white py-1 px-3 rounded">Best Seller</span>
                        </div>
                        <?php endif; ?>
                        <a href="/cars/<?php echo e($car['id']); ?>" class="btn btn-outline-primary w-100">View Details</a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="text-center mt-5">
            <a href="<?php echo e(route('cars')); ?>" class="btn btn-primary">Show more products</a>
        </div>
    </section>
</div>


<div id="carModal" class="modal fade" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="carName"></h5>
        <button type="button" class="btn-close" onclick="closeCarPopup()"></button>
      </div>
      <div class="modal-body">
        <img id="carImage" src="" class="img-fluid mb-3" style="max-height: 300px; object-fit: cover;">
        <p><strong>Price:</strong> $<span id="carPrice"></span></p>
        <p><strong>Rating:</strong> <span id="carRating"></span> ⭐</p>
        <p><strong>Reviews:</strong> <span id="carReviews"></span> reviews</p>
        <h6>Specifications:</h6>
        <ul class="list-group">
          <li class="list-group-item"><strong>Engine:</strong> <span id="carEngine"></span></li>
          <li class="list-group-item"><strong>Fuel Type:</strong> <span id="carFuelType"></span></li>
          <li class="list-group-item"><strong>Transmission:</strong> <span id="carTransmission"></span></li>
          <li class="list-group-item"><strong>Seats:</strong> <span id="carSeats"></span></li>
          <li class="list-group-item"><strong>Color:</strong> <span id="carColor"></span></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function openCarPopup(car) {
        document.getElementById('carName').innerText = car.name;
        document.getElementById('carImage').src = car.image_url;
        document.getElementById('carPrice').innerText = car.price ?? 'Updating';
        document.getElementById('carRating').innerText = parseFloat(car.rating).toFixed(1);
        document.getElementById('carReviews').innerText = car.reviews;

        document.getElementById('carEngine').innerText = car.engine ?? 'N/A';
        document.getElementById('carFuelType').innerText = car.fuel_type ?? 'N/A';
        document.getElementById('carTransmission').innerText = car.transmission ?? 'N/A';
        document.getElementById('carSeats').innerText = car.seats ?? 'N/A';
        document.getElementById('carColor').innerText = car.color ?? 'N/A';

        new bootstrap.Modal(document.getElementById('carModal')).show();
    }

    function closeCarPopup() {
        bootstrap.Modal.getInstance(document.getElementById('carModal')).hide();
    }
        let lastClickedCard = null;
    let clickTimer = null;

    document.querySelectorAll('.car-card').forEach(card => {
        card.addEventListener('click', function () {
            const carId = this.dataset.carId;
            const carData = JSON.parse(this.dataset.carJson);

            if (lastClickedCard === this) {
                clearTimeout(clickTimer);
                lastClickedCard = null;
                window.location.href = `/cars/${carId}`;
            } else {
                lastClickedCard = this;

                clickTimer = setTimeout(() => {
                    openCarPopup(carData);
                    lastClickedCard = null;
                }, 600);
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/Carrio-Motors/resources/views/home.blade.php ENDPATH**/ ?>