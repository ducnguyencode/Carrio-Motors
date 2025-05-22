<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Dealership</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <?php echo $__env->yieldContent('styles'); ?>
    <style>
        :root {
            --primary-color: #1e88e5;
            --primary-dark: #1565c0;
            --secondary-color: #f5f5f5;
            --accent-color: #ff6d00;
            --text-dark: #212121;
            --text-light: #f5f5f5;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* Back to top button */
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            line-height: 50px;
            font-size: 20px;
            z-index: 1000;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            background-color: var(--primary-dark);
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.3);
        }

        .ticker {
            position: fixed;
            bottom: 0;
            background: #000;
            color: #fff;
            width: 100%;
            padding: 5px 15px;
            font-size: 14px;
            z-index: 1000;
        }

        /* Modern Navigation */
        .navbar-modern {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 0.8rem 0;
            transition: all 0.3s ease;
            z-index: 1030;
        }

        /* Improved Sticky Header */
        .navbar-modern.sticky-top {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            animation: slideDown 0.3s ease-out;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95);
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
            }
            to {
                transform: translateY(0);
            }
        }

        .navbar-modern.sticky-top.visible {
            top: 0;
        }

        .navbar-brand img {
            height: 45px;
            transition: all 0.3s ease;
        }

        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            margin: 0 0.2rem;
            border-radius: 4px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            background-color: rgba(30, 136, 229, 0.05);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 70%;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding: 1rem 0;
            min-width: 14rem;
            margin-top: 1rem;
        }

        .dropdown-item {
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: rgba(30, 136, 229, 0.05);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .dropdown-divider {
            margin: 0.5rem 0;
        }

        .wishlist-icon {
            position: relative;
            font-size: 1.3rem;
            transition: all 0.3s ease;
        }

        .wishlist-icon:hover {
            color: var(--accent-color) !important;
            transform: scale(1.1);
        }

        .wishlist-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--accent-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.3s ease;
        }

        .search-btn {
            background-color: var(--primary-color);
            border: none;
            color: white;
            padding: 0.5rem;
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            background-color: var(--primary-dark);
            transform: rotate(90deg);
        }

        /* Video Carousel Styles */
        .video-carousel {
            position: relative;
            width: 100vw;
            height: 90vh;
            overflow: hidden;
            margin-top: -2px; /* Remove gap between navbar and video */
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

        /* Other existing styles */
        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        }
        .btn {
            border-radius: 0.5rem;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
            box-shadow: 0 4px 6px rgba(13, 110, 253, 0.25);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #084298 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(13, 110, 253, 0.35);
        }

        /* Search overlay */
        .search-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.9);
            z-index: 1000;
            display: none;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .search-overlay.active {
            display: flex;
            opacity: 1;
        }

        .search-overlay-content {
            width: 70%;
            max-width: 800px;
        }

        .search-overlay-input {
            width: 100%;
            padding: 1rem;
            font-size: 1.5rem;
            background: transparent;
            border: none;
            border-bottom: 2px solid white;
            color: white;
            outline: none;
        }

        .search-overlay-close {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 2rem;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-overlay-close:hover {
            color: var(--accent-color);
            transform: rotate(90deg);
        }

        /* Main content container */
        .main-content {
            margin-top: 30px;
        }

        /* Footer Styles */
        footer.bg-dark {
            background-color: #212529 !important;
        }

        footer .text-primary {
            color: #1e88e5 !important;
        }

        footer hr.bg-light {
            background-color: rgba(255, 255, 255, 0.2) !important;
            height: 1px;
            opacity: 1;
        }

        footer a.text-white {
            transition: all 0.3s ease;
        }

        footer a.text-white:hover {
            color: #1e88e5 !important;
            text-decoration: underline !important;
        }

        footer .me-3 {
            transition: all 0.3s ease;
        }

        footer .me-3:hover {
            color: #1e88e5 !important;
            transform: translateY(-3px);
        }

        /* Modern Footer Styles */
        .footer {
            background-color: #212121;
            color: #f5f5f5;
            padding-top: 80px;
        }

        .footer-top {
            padding-bottom: 40px;
        }

        .footer-logo {
            margin-bottom: 20px;
        }

        .footer-logo img {
            height: 50px;
        }

        .footer-text {
            color: #bdbdbd;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .social-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(255,255,255,0.1);
            border-radius: 50%;
            color: #f5f5f5;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background-color: #1e88e5;
            transform: translateY(-3px);
        }

        .footer-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 15px;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background-color: #1e88e5;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 15px;
        }

        .footer-links a {
            color: #bdbdbd;
            transition: all 0.3s ease;
            text-decoration: none;
            position: relative;
            padding-left: 15px;
        }

        .footer-links a::before {
            content: '›';
            position: absolute;
            left: 0;
            color: #1e88e5;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: #fff;
            padding-left: 20px;
        }

        .footer-links a:hover::before {
            left: 5px;
        }

        .contact-info {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .contact-info li {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            color: #bdbdbd;
        }

        .contact-info i {
            color: #1e88e5;
            margin-right: 15px;
            font-size: 1.2rem;
        }

        .footer-bottom {
            padding: 20px 0;
            border-top: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }

        .copyright {
            color: #9e9e9e;
        }
    </style>
</head>
<body>
    <!-- Modern Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-modern">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                <img src="<?php echo e(asset('images/logo.svg')); ?>" alt="Carrio Motors">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">
                            <i class="bi bi-house-door-fill me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('about') ? 'active' : ''); ?>" href="<?php echo e(route('about')); ?>">
                            <i class="bi bi-info-circle-fill me-1"></i> About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('cars*') ? 'active' : ''); ?>" href="<?php echo e(route('cars')); ?>">
                            <i class="bi bi-car-front-fill me-1"></i> Cars
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('blog*') ? 'active' : ''); ?>" href="<?php echo e(route('blog')); ?>">
                            <i class="bi bi-journal-text me-1"></i> Blog
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('contact') ? 'active' : ''); ?>" href="<?php echo e(route('contact')); ?>">
                            <i class="bi bi-envelope-fill me-1"></i> Contact
                        </a>
                    </li>
                </ul>
            </div>

            <div class="d-flex align-items-center">
                <button class="search-btn" id="searchToggleBtn" aria-label="Toggle search">
                    <i class="bi bi-search"></i>
                </button>

                <?php if(auth()->guard()->check()): ?>
                <div class="dropdown ms-3">
                    <a class="btn btn-sm btn-outline-dark dropdown-toggle" href="#" role="button" id="userMenuDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuDropdown">
                        <?php if(Auth::user()->role == 'admin'): ?>
                        <li><a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">
                            <i class="bi bi-speedometer2 me-2"></i>Admin Dashboard</a>
                        </li>
                        <?php elseif(Auth::user()->role == 'content'): ?>
                        <li><a class="dropdown-item" href="<?php echo e(route('admin.blog.index')); ?>">
                            <i class="bi bi-newspaper me-2"></i>Blog Management</a>
                        </li>
                        <?php elseif(Auth::user()->role == 'saler'): ?>
                        <li><a class="dropdown-item" href="<?php echo e(route('admin.invoices.index')); ?>">
                            <i class="bi bi-receipt me-2"></i>Invoices</a>
                        </li>
                        <?php endif; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="<?php echo e(route('logout')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Search Overlay -->
    <div class="search-overlay" id="searchOverlay">
        <div class="search-overlay-close" id="searchCloseBtn">
            <i class="bi bi-x-lg"></i>
        </div>
        <div class="search-overlay-content">
            <input type="text" class="search-overlay-input" id="search-input" placeholder="Search for cars...">
            <div id="search-results" class="mt-4 bg-dark text-white"></div>
        </div>
    </div>

    <?php echo $__env->yieldContent('content'); ?>

    <?php echo $__env->yieldContent('footer'); ?>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-chevron-up"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateTicker() {
            const ticker = document.getElementById('ticker');
            if (!ticker) return;

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

        if (document.getElementById('ticker')) {
            updateTicker();
            setInterval(updateTicker, 10000);
        }

        document.addEventListener("DOMContentLoaded", function () {
            // Back to top button functionality
            const backToTopButton = document.getElementById('backToTop');

            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.add('visible');
                } else {
                    backToTopButton.classList.remove('visible');
                }
            });

            backToTopButton.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Slide Banner functionality
            const slides = document.querySelectorAll('.carousel-slide');
            const dots = document.querySelectorAll('.carousel-indicators .dot');

            if (slides.length > 0) {
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

                showSlide(currentIndex);
                setInterval(nextSlide, interval);

                dots.forEach((dot, i) => {
                    dot.addEventListener('click', () => {
                        currentIndex = i;
                        showSlide(currentIndex);
                    });
                });
            }

            // Sticky navbar behavior
            const navbar = document.querySelector('.navbar-modern');
            let lastScrollTop = 0;

            window.addEventListener('scroll', function() {
                let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (scrollTop > 100) {
                    navbar.classList.add('sticky-top');
                } else {
                    navbar.classList.remove('sticky-top');
                }

                lastScrollTop = scrollTop;
            });

            // Search overlay functionality
            const searchToggleBtn = document.getElementById('searchToggleBtn');
            const searchOverlay = document.getElementById('searchOverlay');
            const searchCloseBtn = document.getElementById('searchCloseBtn');
            const searchInput = document.getElementById('search-input');

            if (searchToggleBtn && searchOverlay && searchCloseBtn && searchInput) {
                searchToggleBtn.addEventListener('click', function() {
                    searchOverlay.classList.add('active');
                    setTimeout(() => {
                        searchInput.focus();
                    }, 100);
                });

                searchCloseBtn.addEventListener('click', function() {
                    searchOverlay.classList.remove('active');
                });

                // Close search overlay on ESC key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        searchOverlay.classList.remove('active');
                    }
                });
            }
        });

        // Function placeholder for backwards compatibility
        function updateWishlistCount() {
            // No longer needed since wishlist button was removed
        }
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
                            resultBox.innerHTML = '<div class="p-3 text-center">No results found</div>';
                            return;
                        }
                        data.forEach(car => {
                            const item = document.createElement('div');
                            item.className = 'p-3 border-bottom border-secondary';
                            item.innerHTML = `
                                <a href="/cars/${car.id}" class="d-flex align-items-center text-decoration-none text-white">
                                    <img src="${car.image_url}" alt="${car.name}" style="width: 60px; height: 40px; object-fit: cover; margin-right: 10px;">
                                    <span>${car.name} (${car.brand})</span>
                                </a>
                            `;
                            resultBox.appendChild(item);
                        });
                    });
            }, 300);
        });
    });
    </script>
</body>
</html>
<?php /**PATH /Applications/XAMPP/Carrio-Motors/resources/views/layouts/app.blade.php ENDPATH**/ ?>