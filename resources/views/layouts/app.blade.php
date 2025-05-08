<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Dealership</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .visit-counter {
            position: absolute;
            right: 20px;
            top: 10px;
            font-size: 14px;
            color: #666;
        }
        .video-carousel {
            position: relative;
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
            top: 50%;
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
            left: 50%;
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
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <img src="/logo.png" alt="Logo" style="height: 60px;">
            <div class="visit-counter">Visits: {{ session('visit_count', 1) }}</div>
        </div>
        <nav class="nav nav-pills my-3">
            <a class="nav-link" href="/">Home</a>
            <a class="nav-link" href="/about">About</a>
            <a class="nav-link" href="/cars">Cars</a>
            <a class="nav-link" href="/buy">Buy</a>
            <a class="nav-link" href="/contact">Contact</a>
        </nav>

        @yield('content')
    </div>

    <div class="ticker" id="ticker">
        Loading location and time...
    </div>

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
</body>
</html>
