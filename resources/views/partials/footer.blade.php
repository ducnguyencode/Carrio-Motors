<!-- Footer -->
<footer class="footer bg-dark text-white pt-4 pb-3 mt-4">
    <div class="container footer-top">
        <div class="row">
            <!-- Company Info -->
            <div class="col-md-4 mb-3">
                <div class="footer-logo mb-2">
                    <img src="{{ asset('images/logo.svg') }}" alt="Carrio Motors Logo" style="filter: brightness(6) invert(1); height: 40px;">
                </div>
                <p class="footer-text small mb-2">Your trusted partner for premium vehicles and exceptional service since 2005.</p>
                <div class="social-links mt-2">
                    <a href="https://facebook.com" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com" target="_blank" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="https://instagram.com" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="https://linkedin.com" target="_blank" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-md-2 mb-3">
                <h6 class="mb-2 text-primary footer-title">Quick Links</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('cars') }}">Our Cars</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div class="col-md-2 mb-3">
                <h6 class="mb-2 text-primary footer-title">Services</h6>
                <ul class="footer-links">
                    <li><a href="#">New Cars</a></li>
                    <li><a href="#">Used Cars</a></li>
                    <li><a href="#">Car Service</a></li>
                    <li><a href="#">Financing</a></li>
                    <li><a href="#">Parts & Accessories</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="col-md-4 mb-3">
                <h6 class="mb-2 text-primary footer-title">Contact Us</h6>
                <ul class="contact-info">
                    <li><i class="fas fa-map-marker-alt"></i> 123 Dealership Road, Autoville, AV 12345</li>
                    <li><i class="fas fa-phone-alt"></i> (123) 456-7890</li>
                    <li><i class="fas fa-envelope"></i> info@carriomotors.com</li>
                    <li><i class="fas fa-clock"></i> Mon-Sat: 9am - 6pm, Sun: Closed</li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="row footer-bottom">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0 copyright small">&copy; {{ date('Y') }} Carrio Motors. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0 small">
                    <a href="#" class="text-white text-decoration-none">Privacy Policy</a> |
                    <a href="#" class="text-white text-decoration-none">Terms of Service</a>
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
.footer {
    background-color: #212121;
    color: #f5f5f5;
}

.footer-top {
    padding-bottom: 15px;
}

.footer-logo img {
    height: 40px;
}

.footer-text {
    color: #bdbdbd;
    line-height: 1.4;
}

.social-links {
    display: flex;
    gap: 10px;
}

.social-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
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
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 15px;
    position: relative;
    padding-bottom: 8px;
}

.footer-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 2px;
    background-color: #1e88e5;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 8px;
}

.footer-links a {
    color: #bdbdbd;
    transition: all 0.3s ease;
    text-decoration: none;
    position: relative;
    padding-left: 12px;
    font-size: 0.9rem;
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
    padding-left: 15px;
}

.footer-links a:hover::before {
    left: 3px;
}

.contact-info {
    list-style: none;
    padding: 0;
    margin: 0;
}

.contact-info li {
    display: flex;
    align-items: flex-start;
    margin-bottom: 10px;
    color: #bdbdbd;
    font-size: 0.9rem;
}

.contact-info i {
    color: #1e88e5;
    margin-right: 10px;
    font-size: 1rem;
}

.footer-bottom {
    padding-top: 15px;
    border-top: 1px solid rgba(255,255,255,0.1);
}

.copyright {
    color: #9e9e9e;
}
</style>
