@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <h1 class="fw-bold">Privacy Policy</h1>
            <p class="text-muted">Last Updated: {{ date('F d, Y') }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h4 mb-4">1. Introduction</h2>
                    <p>Welcome to Carrio Motors. We respect your privacy and are committed to protecting your personal data. This privacy policy will inform you how we look after your personal data when you visit our website and tell you about your privacy rights and how the law protects you.</p>

                    <h2 class="h4 mb-4 mt-5">2. The Data We Collect About You</h2>
                    <p>Personal data means any information about an individual from which that person can be identified. We may collect, use, store and transfer different kinds of personal data about you which we have grouped together as follows:</p>

                    <ul class="mb-4">
                        <li><strong>Identity Data</strong> includes first name, last name, username or similar identifier, title, date of birth, and gender.</li>
                        <li><strong>Contact Data</strong> includes billing address, delivery address, email address, and telephone numbers.</li>
                        <li><strong>Financial Data</strong> includes bank account and payment card details.</li>
                        <li><strong>Transaction Data</strong> includes details about payments to and from you and other details of products and services you have purchased from us.</li>
                        <li><strong>Technical Data</strong> includes internet protocol (IP) address, your login data, browser type and version, time zone setting and location, browser plug-in types and versions, operating system and platform, and other technology on the devices you use to access this website.</li>
                        <li><strong>Profile Data</strong> includes your username and password, purchases or orders made by you, your interests, preferences, feedback, and survey responses.</li>
                        <li><strong>Usage Data</strong> includes information about how you use our website, products, and services.</li>
                        <li><strong>Marketing and Communications Data</strong> includes your preferences in receiving marketing from us and our third parties and your communication preferences.</li>
                    </ul>

                    <h2 class="h4 mb-4 mt-5">3. How We Use Your Personal Data</h2>
                    <p>We will only use your personal data when the law allows us to. Most commonly, we will use your personal data in the following circumstances:</p>

                    <ul class="mb-4">
                        <li>Where we need to perform the contract we are about to enter into or have entered into with you.</li>
                        <li>Where it is necessary for our legitimate interests (or those of a third party) and your interests and fundamental rights do not override those interests.</li>
                        <li>Where we need to comply with a legal obligation.</li>
                    </ul>

                    <h2 class="h4 mb-4 mt-5">4. Data Security</h2>
                    <p>We have put in place appropriate security measures to prevent your personal data from being accidentally lost, used, or accessed in an unauthorized way, altered, or disclosed. In addition, we limit access to your personal data to those employees, agents, contractors, and other third parties who have a business need to know.</p>

                    <h2 class="h4 mb-4 mt-5">5. Data Retention</h2>
                    <p>We will only retain your personal data for as long as reasonably necessary to fulfill the purposes we collected it for, including for the purposes of satisfying any legal, regulatory, tax, accounting, or reporting requirements.</p>

                    <h2 class="h4 mb-4 mt-5">6. Your Legal Rights</h2>
                    <p>Under certain circumstances, you have rights under data protection laws in relation to your personal data, including the right to:</p>

                    <ul class="mb-4">
                        <li>Request access to your personal data.</li>
                        <li>Request correction of your personal data.</li>
                        <li>Request erasure of your personal data.</li>
                        <li>Object to processing of your personal data.</li>
                        <li>Request restriction of processing your personal data.</li>
                        <li>Request transfer of your personal data.</li>
                        <li>Right to withdraw consent.</li>
                    </ul>

                    <h2 class="h4 mb-4 mt-5">7. Cookies</h2>
                    <p>Cookies are small files that a site or its service provider transfers to your computer's hard drive through your Web browser (if you allow) that enables the site's or service provider's systems to recognize your browser and capture and remember certain information.</p>
                    <p>We use cookies to help us remember and process the items in your shopping cart, understand and save your preferences for future visits, and compile aggregate data about site traffic and site interaction so that we can offer better site experiences and tools in the future.</p>

                    <h2 class="h4 mb-4 mt-5">8. Changes to the Privacy Policy</h2>
                    <p>We may update our privacy policy from time to time. We will notify you of any changes by posting the new privacy policy on this page and updating the "Last Updated" date at the top of this privacy policy.</p>

                    <h2 class="h4 mb-4 mt-5">9. Contact Us</h2>
                    <p>If you have any questions about this privacy policy or our privacy practices, please contact us at:</p>

                    <address class="mb-4">
                        <strong>Carrio Motors</strong><br>
                        35/6 D5, ward 25, Binh Thanh district<br>
                        TP.HCM, Vietnam<br>
                        <br>
                        <strong>Email:</strong> privacy@carriomotors.com<br>
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
