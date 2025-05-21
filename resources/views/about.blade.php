@extends('layouts.app')

@section('content')
<div class="position-relative">
    <img src="{{ asset('images/Carrio_Motors_Showroom.jpg') }}" alt="Carrio Motors Showroom" class="w-100" style="height: 400px; object-fit: cover; object-position: center;">
    <div class="position-absolute top-0 left-0 w-100 h-100 bg-dark" style="opacity: 0.6;"></div>
    <div class="position-absolute top-0 left-0 w-100 h-100 d-flex align-items-center">
        <div class="container text-center text-white">
            <h1 class="display-3 fw-bold">About Carrio Motors</h1>
            <p class="lead">Your premier destination for luxury and performance vehicles</p>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    <span class="h1 mb-0">18</span>
                </div>
                <div class="ms-3">
                    <span class="d-block text-muted">years</span>
                    <span class="h5">Premium Automotive Excellence</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5 align-items-center">
        <div class="col-md-6">
            <h2 class="display-4 mb-4">Our Story</h2>
            <div>
                <p class="lead">Carrio Motors is committed to delivering high customer satisfaction with discipline, focus, and speed in the automotive industry.</p>
                <p>Founded in 2005, we've grown from a small local dealership to one of the region's most trusted automotive retailers, offering premium vehicles from brands like BMW, Audi, Mercedes-Benz, and more.</p>
                <p>Our philosophy centers on transparency, quality, and customer-first approach, ensuring that each client drives away with not just a car, but a lasting relationship with our brand.</p>
            </div>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('images/car_dealership_showroom.jpg') }}" alt="Carrio Motors Dealership" class="img-fluid rounded shadow-lg">
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12 text-center mb-5">
            <h2 class="display-4">Our Mission & Values</h2>
            <p class="lead mb-5">We're driven by a commitment to excellence and innovation in everything we do.</p>
        </div>

        <div class="col-md-4 text-center mb-4">
            <div class="bg-light rounded-circle mx-auto d-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                <i class="fas fa-trophy text-primary" style="font-size: 40px;"></i>
            </div>
            <h4>Excellence</h4>
            <p>We strive to exceed expectations in every vehicle we offer and every service we provide, from sales to maintenance and beyond.</p>
        </div>

        <div class="col-md-4 text-center mb-4">
            <div class="bg-light rounded-circle mx-auto d-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                <i class="fas fa-shield-alt text-primary" style="font-size: 40px;"></i>
            </div>
            <h4>Integrity</h4>
            <p>We maintain the highest ethical standards in all our dealings, ensuring transparency and honesty throughout the car buying process.</p>
        </div>

        <div class="col-md-4 text-center mb-4">
            <div class="bg-light rounded-circle mx-auto d-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                <i class="fas fa-bolt text-primary" style="font-size: 40px;"></i>
            </div>
            <h4>Innovation</h4>
            <p>We constantly seek new ways to improve our vehicle offerings, financing options, and after-sales service to meet evolving customer needs.</p>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12 text-center mb-5">
            <h2 class="display-4">Our Leadership Team</h2>
            <p class="lead mb-5">Meet the experienced automotive professionals who drive our vision forward.</p>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <img src="{{ asset('images/CEO.jpg') }}" class="card-img-top" alt="CEO" style="height: 250px; object-fit: cover;">
                <div class="card-body text-center">
                    <h5 class="card-title">Michael Johnson</h5>
                    <p class="text-muted">Chief Executive Officer</p>
                    <p class="card-text small">With over 20 years in the automotive industry, Michael leads our company with vision and expertise.</p>
                    <div class="mt-3">
                        <a href="#" class="text-dark me-2"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-dark me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-dark"><i class="far fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <img src="{{ asset('images/COO.jpg') }}" class="card-img-top" alt="COO" style="height: 250px; object-fit: cover;">
                <div class="card-body text-center">
                    <h5 class="card-title">Sarah Williams</h5>
                    <p class="text-muted">Chief Operations Officer</p>
                    <p class="card-text small">Sarah ensures our dealership operations run smoothly, focusing on efficiency and customer satisfaction.</p>
                    <div class="mt-3">
                        <a href="#" class="text-dark me-2"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-dark me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-dark"><i class="far fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <img src="{{ asset('images/Sales_Director.jpg') }}" class="card-img-top" alt="Sales Director" style="height: 250px; object-fit: cover;">
                <div class="card-body text-center">
                    <h5 class="card-title">David Chen</h5>
                    <p class="text-muted">Sales Director</p>
                    <p class="card-text small">David leads our sales team with an innovative approach, helping customers find their perfect vehicle match.</p>
                    <div class="mt-3">
                        <a href="#" class="text-dark me-2"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-dark me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-dark"><i class="far fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <img src="{{ asset('images/Service_Manager.jpg') }}" class="card-img-top" alt="Service Manager" style="height: 250px; object-fit: cover;">
                <div class="card-body text-center">
                    <h5 class="card-title">Emily Rodriguez</h5>
                    <p class="text-muted">Customer Service Manager</p>
                    <p class="card-text small">Emily ensures that every customer interaction exceeds expectations, from test drives to after-sales service.</p>
                    <div class="mt-3">
                        <a href="#" class="text-dark me-2"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-dark me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-dark"><i class="far fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2 class="display-4">Why Choose Carrio Motors</h2>
            <p class="lead mb-5">Discover the advantages that set us apart in the automotive industry</p>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-car"></i>
                        </div>
                        <h4 class="mb-0">Premium Selection</h4>
                    </div>
                    <p>We offer a curated collection of luxury and performance vehicles from the world's top automotive brands.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h4 class="mb-0">Expert Service</h4>
                    </div>
                    <p>Our factory-trained technicians use state-of-the-art equipment to keep your vehicle performing at its best.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <h4 class="mb-0">Financing Solutions</h4>
                    </div>
                    <p>We offer competitive financing and leasing options tailored to your budget and preferences.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')
@endsection

@push('styles')
<style>
    .hover-card {
        transition: all 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endpush
