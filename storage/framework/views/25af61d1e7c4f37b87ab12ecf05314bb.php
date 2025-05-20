<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Dealership</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php echo $__env->yieldContent('styles'); ?>
    <style>
        .ticker {
            position: fixed;
            bottom: 0;
            background: #000;
            color: #fff;
            width: 100%;
            padding: 5px 15px;
            font-size: 14px;
        }
        .video-carousel {
            position: relative;
            width: 100vw;
            margin-left: calc(-50vw + 50%);
            height: 90vh;
            overflow: hidden;
        }

        .carousel-slide {
            display: none;
            position: absolute;
            width: 100%;
            height: 100%;
        }
        .carousel-slide.active {
            display: block;
        }
        .background-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .carousel-content {
            position: absolute;
            top: 90%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
        }
        .carousel-content h1 {
            font-size: 3rem;
            font-weight: bold;
        }
        .carousel-content h4 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        .carousel-indicators {
            position: absolute;
            bottom: 20px;
            left: 0%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
        }
        .carousel-indicators .dot {
            width: 12px;
            height: 12px;
            background: #fff;
            border-radius: 50%;
            opacity: 0.5;
            cursor: pointer;
        }
        .carousel-indicators .dot.active {
            opacity: 1;
        }
        .dropdown-menu {
            min-width: 12rem;
        }
        .bg-gradient-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        }
        .btn {
            border-radius: 0.5rem;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            border: none;
            box-shadow: 0 4px 6px rgba(13, 110, 253, 0.25);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #0a58ca 0%, #084298 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(13, 110, 253, 0.35);
        }

        .search-container {
            margin-bottom: 30px;
        }

        #search-results {
            background: white;
            border: 1px solid #ccc;
            border-top: none;
            margin-top: -1px;
            margin-bottom: 30px;
        }

    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
        <a href="<?php echo e(url('/')); ?>">
            <img src="images/logo.svg" style="height: 40px;">
        </a>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3 mb-3">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/"><i class="fas fa-home me-1"></i> Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/about"><i class="fas fa-info-circle me-1"></i> About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/cars"><i class="fas fa-car me-1"></i> Cars</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/buy"><i class="fas fa-shopping-cart me-1"></i> Buy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/contact"><i class="fas fa-envelope me-1"></i> Contact</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav">
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <?php echo $__env->yieldContent('content'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function updateTicker() {
            const ticker = document.getElementById('ticker');
            navigator.geolocation.getCurrentPosition(pos => {
                const lat = pos.coords.latitude.toFixed(2);
                const lon = pos.coords.longitude.toFixed(2);
                const date = new Date();
                ticker.innerText = `Date: ${date.toLocaleDateString()} | Time: ${date.toLocaleTimeString()} | Location: [${lat}, ${lon}]`;
            }, () => {
                const date = new Date();
                ticker.innerText = `Date: ${date.toLocaleDateString()} | Time: ${date.toLocaleTimeString()} | Location: Not available`;
            });
        }
        updateTicker();
        setInterval(updateTicker, 10000);

        document.addEventListener("DOMContentLoaded", function () {
            const slides = document.querySelectorAll('.carousel-slide');
            const dots = document.querySelectorAll('.carousel-indicators .dot');
            let currentIndex = 0;
            const interval = 10000;

            function showSlide(index) {
                slides.forEach((slide, i) => {
                    slide.classList.toggle('active', i === index);
                    const video = slide.querySelector('video');
                    if (video) {
                        if (i === index) {
                            video.play();
                        } else {
                            video.pause();
                            video.currentTime = 0;
                        }
                    }
                    if (dots[i]) dots[i].classList.toggle('active', i === index);
                });
            }

            function nextSlide() {
                currentIndex = (currentIndex + 1) % slides.length;
                showSlide(currentIndex);
            }

            if (slides.length > 0) {
                showSlide(currentIndex);
                setInterval(nextSlide, interval);
            }

            dots.forEach((dot, i) => {
                dot.addEventListener('click', () => {
                    currentIndex = i;
                    showSlide(currentIndex);
                });
            });
        });
    </script>

    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('search-input');
        const resultBox = document.getElementById('search-results');
        if (!input || !resultBox) return;

        let timeout = null;

        input.addEventListener('input', function () {
            clearTimeout(timeout);
            const query = input.value.trim();
            if (!query) {
                resultBox.innerHTML = '';
                return;
            }

            timeout = setTimeout(() => {
                fetch(`/search/cars?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        resultBox.innerHTML = '';
                        if (data.length === 0) {
                            resultBox.innerHTML = '<li class="list-group-item text-muted">No results found</li>';
                            return;
                        }
                        data.forEach(car => {
                            const li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.innerHTML = `
                                <a href="/cars/${car.id}" class="d-flex align-items-center text-decoration-none text-dark">
                                    <img src="${car.image_url}" alt="${car.name}" style="width: 60px; height: 40px; object-fit: cover; margin-right: 10px;">
                                    <span>${car.name} (${car.brand})</span>
                                </a>
                            `;
                            resultBox.appendChild(li);
                        });
                    });
            }, 300);
        });
    });
    </script>

    
    <script>
    function toggleMoreCars() {
        const more = document.getElementById('more-cars');
        more.classList.toggle('hidden');
    }
    </script>
</body>
</html>
<?php /**PATH D:\Project\Carrio-Motors\resources\views/layouts/app.blade.php ENDPATH**/ ?>