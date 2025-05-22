<!-- Footer -->
<footer class="footer pt-5 pb-3 mt-4">
    <div class="container">
        <!-- Main Footer Content -->
        <div class="row g-4 mb-4">
            <!-- Company Info -->
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand mb-4">
                    <img src="{{ asset('images/logo.svg') }}" alt="Carrio Motors Logo" class="footer-logo" style="filter: brightness(6) invert(1); height: 48px;">
                </div>
                <p class="footer-description mb-4">Your trusted partner for premium vehicles and exceptional service since 2005.</p>

                <div class="social-icons">
                    @php
                        $socialLinks = \App\Models\SocialMediaLink::active()->ordered()->get();
                    @endphp
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="social-icon-link" aria-label="{{ $link->platform_name }}">
                            <i class="{{ $link->icon_class }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 col-6">
                <h5 class="footer-heading">Quick Links</h5>
                <ul class="footer-nav">
                    <li><a href="{{ route('home') }}" class="footer-link"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="{{ route('about') }}" class="footer-link"><i class="fas fa-chevron-right"></i> About Us</a></li>
                    <li><a href="{{ route('cars') }}" class="footer-link"><i class="fas fa-chevron-right"></i> Our Cars</a></li>
                    <li><a href="{{ route('blog') }}" class="footer-link"><i class="fas fa-chevron-right"></i> Blog</a></li>
                    <li><a href="{{ route('contact') }}" class="footer-link"><i class="fas fa-chevron-right"></i> Contact</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div class="col-lg-2 col-md-6 col-6">
                <h5 class="footer-heading">Services</h5>
                <ul class="footer-nav">
                    <li><a href="{{ route('contact') }}?subject=Test+Drive" class="footer-link"><i class="fas fa-chevron-right"></i> Schedule Test Drive</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="col-lg-4 col-md-6">
                <h5 class="footer-heading">Contact Us</h5>
                <ul class="footer-contact">
                    <li class="d-flex align-items-start mb-3">
                        <div class="icon-wrapper">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <span>35/6 D5, ward 25, Binh Thanh district, TP.HCM, Vietnam</span>
                    </li>
                    <li class="d-flex align-items-start mb-3">
                        <div class="icon-wrapper">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <span>1800-838-668 / +84 28 3512 1234</span>
                    </li>
                    <li class="d-flex align-items-start mb-3">
                        <div class="icon-wrapper">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <span>info@carriomotors.com</span>
                    </li>
                    <li class="d-flex align-items-start">
                        <div class="icon-wrapper">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span>Mon-Fri: 8am - 6pm, Sat: 9am - 5pm, Sun: Closed</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Divider -->
        <hr class="footer-divider">

        <!-- Copyright Row -->
        <div class="row footer-copyright py-3">
            <div class="col-md-6 col-12 text-center text-md-start">
                <p class="mb-0">&copy; {{ date('Y') }} Carrio Motors. All rights reserved.</p>
            </div>
            <div class="col-md-6 col-12 text-center text-md-end">
                <a href="{{ route('privacy-policy') }}" class="footer-policy-link">Privacy Policy</a>
                <span class="mx-2">|</span>
                <a href="{{ route('terms-of-service') }}" class="footer-policy-link">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<style>
/* Modern Footer Styling */
.footer {
    background-color: #1a1a2e;
    color: #e2e2e2;
    position: relative;
}

.footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, #1e88e5, #42a5f5, #1e88e5);
}

.footer-brand {
    margin-bottom: 1.5rem;
}

.footer-logo {
    height: 48px;
    transition: transform 0.3s ease;
}

.footer-logo:hover {
    transform: scale(1.05);
}

.footer-description {
    color: #b0b0b0;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.social-icons {
    display: flex;
    gap: 12px;
    margin-top: 1.5rem;
}

.social-icon-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    font-size: 16px;
    transition: all 0.3s ease;
}

.social-icon-link:hover {
    background-color: #1e88e5;
    color: #ffffff;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(30, 136, 229, 0.3);
}

.footer-heading {
    color: #ffffff;
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    position: relative;
    padding-bottom: 10px;
}

.footer-heading::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 3px;
    background-color: #1e88e5;
    border-radius: 2px;
}

.footer-nav {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-nav li {
    margin-bottom: 12px;
}

.footer-link {
    color: #b0b0b0;
    text-decoration: none;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
}

.footer-link i {
    font-size: 0.75rem;
    margin-right: 8px;
    color: #1e88e5;
    transition: transform 0.3s ease;
}

.footer-link:hover {
    color: #ffffff;
    padding-left: 5px;
}

.footer-link:hover i {
    transform: translateX(3px);
}

.footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-contact li {
    color: #b0b0b0;
    font-size: 0.95rem;
    margin-bottom: 15px;
}

.icon-wrapper {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    background-color: #1e88e5;
    border-radius: 50%;
    margin-right: 15px;
    min-width: 24px;
    color: #ffffff;
    font-size: 0.8rem;
}

.footer-divider {
    margin: 1.5rem 0;
    border-color: rgba(255, 255, 255, 0.1);
}

.footer-copyright {
    color: #888888;
    font-size: 0.9rem;
}

.footer-policy-link {
    color: #888888;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-policy-link:hover {
    color: #1e88e5;
}

@media (max-width: 767.98px) {
    .footer-heading {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    .footer-copyright {
        text-align: center;
    }

    .footer-nav li {
        margin-bottom: 10px;
    }
}
</style>
