@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <h1 class="fw-bold">Terms of Service</h1>
            <p class="text-muted">Last Updated: {{ date('F d, Y') }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h4 mb-4">1. Introduction</h2>
                    <p>Welcome to Carrio Motors. These terms and conditions govern your use of our website and the purchase of vehicles and related services from us.</p>
                    <p>By using our website or purchasing our products and services, you agree to these Terms of Service. Please read them carefully.</p>

                    <h2 class="h4 mb-4 mt-5">2. Acceptance of Terms</h2>
                    <p>By accessing and using our website, you accept and agree to be bound by these Terms of Service. If you do not agree to these terms, you should not use our website or services.</p>

                    <h2 class="h4 mb-4 mt-5">3. Vehicle Information</h2>
                    <p>We make every effort to provide accurate information about our vehicles, including specifications, features, and pricing. However, we cannot guarantee that all information is complete, accurate, or current. In the event of a discrepancy between information on our website and the actual vehicle or official documentation, the latter will prevail.</p>

                    <h2 class="h4 mb-4 mt-5">4. Vehicle Reservations and Purchases</h2>
                    <p>When you reserve or purchase a vehicle through our website:</p>

                    <ul class="mb-4">
                        <li>Your reservation or purchase is subject to vehicle availability and final confirmation by us.</li>
                        <li>You agree to provide accurate and complete information for the transaction.</li>
                        <li>The final purchase agreement will be the written contract signed at our dealership.</li>
                        <li>Any deposit made may be subject to our refund policy as detailed in the reservation confirmation.</li>
                    </ul>

                    <h2 class="h4 mb-4 mt-5">5. Payment Terms</h2>
                    <p>Payment for vehicles and services may be made by the methods specified on our website. All prices are subject to applicable taxes and fees, which will be clearly disclosed before completion of purchase.</p>

                    <h2 class="h4 mb-4 mt-5">6. Delivery and Inspection</h2>
                    <p>Vehicle delivery will be arranged as agreed upon purchase. Upon delivery, you should inspect the vehicle carefully and note any issues or discrepancies. Any issues should be reported to us immediately.</p>

                    <h2 class="h4 mb-4 mt-5">7. Warranties</h2>
                    <p>New vehicles come with the manufacturer's warranty. Used vehicles may come with a limited warranty as specified at the time of purchase. These warranties are subject to the terms and conditions provided in the warranty documentation.</p>

                    <h2 class="h4 mb-4 mt-5">8. Return Policy</h2>
                    <p>Our vehicle return policy, if applicable, will be clearly communicated at the time of purchase. Any returns must comply with the specified conditions and timeframe.</p>

                    <h2 class="h4 mb-4 mt-5">9. Website Use</h2>
                    <p>You agree to use our website only for lawful purposes and in a manner that does not infringe the rights of any third party. You must not:</p>

                    <ul class="mb-4">
                        <li>Use our website in any way that could damage, disable, overburden, or impair our servers or networks.</li>
                        <li>Attempt to gain unauthorized access to any part of our website or computer systems.</li>
                        <li>Use any automated means to access our website or collect any information from it.</li>
                        <li>Use our website for any commercial purpose without our prior written consent.</li>
                    </ul>

                    <h2 class="h4 mb-4 mt-5">10. Intellectual Property</h2>
                    <p>All content on our website, including text, graphics, logos, images, and software, is our property or the property of our licensors and is protected by copyright and other intellectual property laws.</p>

                    <h2 class="h4 mb-4 mt-5">11. Limitation of Liability</h2>
                    <p>To the maximum extent permitted by law, we shall not be liable for any indirect, incidental, special, consequential, or punitive damages, or any loss of profits or revenue, arising out of or relating to your use of our website or our products and services.</p>

                    <h2 class="h4 mb-4 mt-5">12. Governing Law</h2>
                    <p>These Terms of Service shall be governed by and construed in accordance with the laws of Vietnam, without regard to its conflict of law principles.</p>

                    <h2 class="h4 mb-4 mt-5">13. Changes to Terms</h2>
                    <p>We reserve the right to modify these Terms of Service at any time. We will notify you of any changes by posting the new Terms of Service on this page and updating the "Last Updated" date at the top.</p>

                    <h2 class="h4 mb-4 mt-5">14. Contact Us</h2>
                    <p>If you have any questions about these Terms of Service, please contact us at:</p>

                    <address class="mb-4">
                        <strong>Carrio Motors</strong><br>
                        35/6 D5, ward 25, Binh Thanh district<br>
                        TP.HCM, Vietnam<br>
                        <br>
                        <strong>Email:</strong> legal@carriomotors.com<br>
                        <strong>Phone:</strong> +84 28 3512 1234
                    </address>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
