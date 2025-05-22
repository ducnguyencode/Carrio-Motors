@extends('layouts.app')
@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <h1 class="fw-bold">Contact Us</h1>
            <p class="lead text-muted">We'd love to hear from you. Get in touch with our team.</p>
        </div>
    </div>

    <div class="row">
        <!-- Contact Info -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4">Reach Out to Us</h5>

                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold">Our Location</h6>
                            <p class="text-muted mb-0">35/6 D5, ward 25, Binh Thanh district, TP.HCM, Vietnam</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold">Phone Number</h6>
                            <p class="text-muted mb-0">1800-838-668</p>
                            <p class="text-muted mb-0">+84 28 3512 1234</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold">Email Address</h6>
                            <p class="text-muted mb-0">info@carriomotors.com</p>
                            <p class="text-muted mb-0">support@carriomotors.com</p>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold">Business Hours</h6>
                            <p class="text-muted mb-0">Monday - Friday: 8:00 AM - 6:00 PM</p>
                            <p class="text-muted mb-0">Saturday: 9:00 AM - 5:00 PM</p>
                            <p class="text-muted mb-0">Sunday: Closed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4">Send Us a Message</h5>

                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form id="contactForm" action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Your Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your name" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter your phone number">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="subject" class="form-label">Subject</label>
                                <select class="form-select @error('subject') is-invalid @enderror" id="subject" name="subject" required>
                                    <option value="" selected disabled>Select a subject</option>
                                    <option value="Sales Inquiry" {{ old('subject') == 'Sales Inquiry' ? 'selected' : '' }}>Sales Inquiry</option>
                                    <option value="Service Request" {{ old('subject') == 'Service Request' ? 'selected' : '' }}>Service Request</option>
                                    <option value="Test Drive" {{ old('subject') == 'Test Drive' ? 'selected' : '' }}>Schedule Test Drive</option>
                                    <option value="Car Purchase" {{ old('subject') == 'Car Purchase' ? 'selected' : '' }}>Car Purchase</option>
                                    <option value="Parts" {{ old('subject') == 'Parts' ? 'selected' : '' }}>Parts & Accessories</option>
                                    <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Car Purchase Fields (Hiển thị khi chọn Car Purchase) -->
                            <div class="col-12" id="carPurchaseFields" style="display: none;">
                                <div class="card border-0 shadow-sm mt-2 mb-3">
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold mb-3">Purchase Information</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="car" class="form-label">Select Car</label>
                                                <select class="form-select @error('car') is-invalid @enderror" id="car" name="car">
                                                    <option value="" selected disabled>Choose a car model</option>
                                                    <option value="Aventador V8" {{ old('car') == 'Aventador V8' ? 'selected' : '' }}>Aventador V8</option>
                                                    <option value="Model S" {{ old('car') == 'Model S' ? 'selected' : '' }}>Model S</option>
                                                    <option value="M850i Coupe" {{ old('car') == 'M850i Coupe' ? 'selected' : '' }}>M850i Coupe</option>
                                                    <option value="AMG GT" {{ old('car') == 'AMG GT' ? 'selected' : '' }}>AMG GT</option>
                                                </select>
                                                @error('car')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="quantity" class="form-label">Quantity</label>
                                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" min="1" value="{{ old('quantity', 1) }}">
                                                @error('quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <label for="payment_method" class="form-label">Payment Method</label>
                                                <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method">
                                                    <option value="" selected disabled>Select payment method</option>
                                                    <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                                    <option value="Credit Card" {{ old('payment_method') == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                                                    <option value="Bank Transfer" {{ old('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                                    <option value="Financing" {{ old('payment_method') == 'Financing' ? 'selected' : '' }}>Financing</option>
                                                </select>
                                                @error('payment_method')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="message" class="form-label">Your Message</label>
                                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" placeholder="Enter your message here" required>{{ old('message') }}</textarea>
                                @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input @error('privacy') is-invalid @enderror" type="checkbox" id="privacy" name="privacy" required>
                                    <label class="form-check-label" for="privacy">
                                        I agree to the <a href="{{ route('privacy-policy') }}">privacy policy</a> and <a href="{{ route('terms-of-service') }}">terms of service</a>
                                    </label>
                                    @error('privacy')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary px-5 py-2">
                                    <i class="fas fa-paper-plane me-2"></i>Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="row mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <h5 class="card-title fw-bold p-4 mb-0">Our Location</h5>
                    <div class="ratio ratio-21x9">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.0622216284587!2d106.7113020749039!3d10.80507098931177!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528a27a24028d%3A0x17beeaca582c5be!2zMzUgxJDGsOG7nW5nIEQ1LCBQaMaw4budbmcgMjUsIELDrG5oIFRo4bqhbmgsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1653105070168!5m2!1svi!2s"
                                style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="p-4">
                        <a href="https://maps.app.goo.gl/fzfBxsnU1YF77KNs9" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-directions me-2"></i>Get Directions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-4">
                <h2 class="fw-bold">Frequently Asked Questions</h2>
                <p class="text-muted">Find answers to common questions about our services</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                How can I schedule a test drive?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can schedule a test drive by filling out the contact form on this page, calling our sales department at 1800-838-668, or visiting our dealership during business hours. We recommend scheduling at least 24 hours in advance to ensure the vehicle you want to test drive is available.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                What financing options do you offer?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We offer a variety of financing options to fit your needs, including traditional auto loans, lease options, and special financing for those with less-than-perfect credit. Our finance team works with multiple lenders to find the best rates and terms for your situation.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Do you accept trade-ins?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, we accept trade-ins of all makes and models. Our team will provide a fair market evaluation of your current vehicle, and the value can be applied directly to your new purchase, reducing your out-of-pocket expense.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials.footer')
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // JavaScript validation is now additional to server-side validation
        const contactForm = document.getElementById('contactForm');
        const subjectSelect = document.getElementById('subject');
        const carPurchaseFields = document.getElementById('carPurchaseFields');

        // Hiển thị/ẩn trường mua xe dựa vào chủ đề được chọn
        function toggleCarPurchaseFields() {
            if (subjectSelect.value === 'Car Purchase') {
                carPurchaseFields.style.display = 'block';
                // Make car, quantity, and payment fields required
                document.getElementById('car').setAttribute('required', 'required');
                document.getElementById('quantity').setAttribute('required', 'required');
                document.getElementById('payment_method').setAttribute('required', 'required');
            } else {
                carPurchaseFields.style.display = 'none';
                // Remove required attribute
                document.getElementById('car').removeAttribute('required');
                document.getElementById('quantity').removeAttribute('required');
                document.getElementById('payment_method').removeAttribute('required');
            }
        }

        // Set initial state
        if (subjectSelect) {
            toggleCarPurchaseFields();

            // Listen for changes in subject selection
            subjectSelect.addEventListener('change', toggleCarPurchaseFields);
        }

        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                let hasError = false;

                // Validate name
                const nameInput = document.getElementById('name');
                if (!nameInput.value.trim()) {
                    hasError = true;
                }

                // Validate email
                const emailInput = document.getElementById('email');
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(emailInput.value.trim())) {
                    hasError = true;
                }

                // Validate subject
                if (subjectSelect.value === '') {
                    hasError = true;
                }

                // Validate car purchase fields if Car Purchase is selected
                if (subjectSelect.value === 'Car Purchase') {
                    const carSelect = document.getElementById('car');
                    const quantityInput = document.getElementById('quantity');
                    const paymentMethodSelect = document.getElementById('payment_method');

                    if (carSelect.value === '') {
                        hasError = true;
                    }

                    if (!quantityInput.value || quantityInput.value < 1) {
                        hasError = true;
                    }

                    if (paymentMethodSelect.value === '') {
                        hasError = true;
                    }
                }

                // Validate message
                const messageInput = document.getElementById('message');
                if (!messageInput.value.trim()) {
                    hasError = true;
                }

                // Validate privacy checkbox
                const privacyCheckbox = document.getElementById('privacy');
                if (!privacyCheckbox.checked) {
                    hasError = true;
                }

                // If there are errors, prevent form submission
                if (hasError) {
                    e.preventDefault();
                    alert('Please fill out all required fields correctly.');
                } else {
                    // Form will be submitted and processed by the server
                    // No need to prevent default or show custom alerts
                }
            });
        }
    });
</script>
@endpush
