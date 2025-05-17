@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-0">
                    <div class="row">
                        <!-- Left side - Image -->
                        <div class="col-lg-5 d-none d-lg-block">
                            <div class="bg-image h-100" style="background-image: url('https://images.unsplash.com/photo-1494905998402-395d579af36f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1400&q=80'); background-size: cover; background-position: center; border-radius: 5px 0 0 5px;">
                                <div class="h-100 d-flex align-items-center justify-content-center p-4" style="background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0.4));">
                                    <div class="text-white text-center">
                                        <h2 class="fw-bold mb-3">Reset Password</h2>
                                        <p class="mb-0">Create a new secure password for your Carrio Motors account.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right side - Form -->
                        <div class="col-lg-7 p-4">
                            <h3 class="fw-bold mb-1">Create New Password</h3>
                            <p class="text-muted small mb-3">Please ensure your new password meets all requirements</p>

                            @if (session('status'))
                                <div class="alert alert-success mb-3">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.update') }}" id="resetPasswordForm">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="mb-3">
                                    <label for="email" class="form-label small fw-bold">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-envelope text-muted"></i>
                                        </span>
                                        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                    </div>
                                    @error('email')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label small fw-bold">New Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">
                                                <i class="fas fa-lock text-muted"></i>
                                            </span>
                                            <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                                            <span class="input-group-text bg-white" style="border-left: 0;" id="togglePassword">
                                                <i class="fas fa-eye-slash text-muted" id="toggleIcon"></i>
                                            </span>
                                        </div>
                                        @error('password')
                                            <div class="text-danger mt-1 small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="password-confirm" class="form-label small fw-bold">Confirm Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">
                                                <i class="fas fa-lock text-muted"></i>
                                            </span>
                                            <input id="password-confirm" name="password_confirmation" type="password" class="form-control" required autocomplete="new-password">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 p-3 bg-light rounded-3 border-start border-primary border-4">
                                    <h6 class="mb-2 fw-bold"><i class="fas fa-shield-alt me-2"></i>Password Requirements</h6>
                                    <ul class="password-requirements mb-0 ps-3 small" id="requirements">
                                        <li id="length-check" class="text-muted"><i class="fas fa-times-circle me-1"></i> At least 8 characters long</li>
                                        <li id="case-check" class="text-muted"><i class="fas fa-times-circle me-1"></i> Include uppercase and lowercase letters</li>
                                        <li id="number-check" class="text-muted"><i class="fas fa-times-circle me-1"></i> Include at least one number</li>
                                        <li id="special-check" class="text-muted"><i class="fas fa-times-circle me-1"></i> Include at least one special character</li>
                                    </ul>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="submit" id="resetButton" class="btn btn-primary py-2 px-4" style="background: linear-gradient(to right, #4f46e5, #0ea5e9); border: none;" disabled>
                                        Reset Password
                                    </button>

                                    <a href="{{ url('/admin') }}" class="text-decoration-none">
                                        Remember your password? Sign in
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-primary:hover {
        background: linear-gradient(to right, #4338ca, #0284c7) !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
        transition: all 0.2s;
    }

    .card {
        border-radius: 10px;
        overflow: hidden;
    }

    .input-group-text {
        border-right: 0;
    }

    .form-control {
        border-left: 0;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }

    .password-requirements li.valid {
        color: #198754 !important;
    }

    .password-requirements li.valid i {
        color: #198754 !important;
    }

    .password-requirements li.invalid {
        color: #dc3545 !important;
    }

    .password-requirements li.invalid i {
        color: #dc3545 !important;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password-confirm');
        const toggleIcon = document.getElementById('toggleIcon');
        const resetButton = document.getElementById('resetButton');
        const lengthCheck = document.getElementById('length-check');
        const caseCheck = document.getElementById('case-check');
        const numberCheck = document.getElementById('number-check');
        const specialCheck = document.getElementById('special-check');

        // Toggle password visibility
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'password') {
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });

        // Password validation
        function validatePassword() {
            const password = passwordInput.value;

            // Check length
            const lengthValid = password.length >= 8;
            updateRequirement(lengthCheck, lengthValid);

            // Check for uppercase and lowercase
            const caseValid = /[a-z]/.test(password) && /[A-Z]/.test(password);
            updateRequirement(caseCheck, caseValid);

            // Check for numbers
            const numberValid = /[0-9]/.test(password);
            updateRequirement(numberCheck, numberValid);

            // Check for special characters
            const specialValid = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
            updateRequirement(specialCheck, specialValid);

            // Enable/disable button based on all requirements and matching passwords
            const allValid = lengthValid && caseValid && numberValid && specialValid;
            const passwordsMatch = password === confirmPasswordInput.value && password !== '';

            resetButton.disabled = !(allValid && passwordsMatch);
        }

        function updateRequirement(element, isValid) {
            if (isValid) {
                element.classList.remove('invalid', 'text-muted');
                element.classList.add('valid');
                element.querySelector('i').classList.remove('fa-times-circle');
                element.querySelector('i').classList.add('fa-check-circle');
            } else {
                element.classList.remove('valid', 'text-muted');
                element.classList.add('invalid');
                element.querySelector('i').classList.remove('fa-check-circle');
                element.querySelector('i').classList.add('fa-times-circle');
            }
        }

        // Check password match
        function checkPasswordMatch() {
            if (confirmPasswordInput.value === '') {
                return;
            }

            if (passwordInput.value === confirmPasswordInput.value) {
                confirmPasswordInput.classList.remove('is-invalid');
                confirmPasswordInput.classList.add('is-valid');
            } else {
                confirmPasswordInput.classList.remove('is-valid');
                confirmPasswordInput.classList.add('is-invalid');
            }

            validatePassword();
        }

        // Add event listeners
        passwordInput.addEventListener('keyup', validatePassword);
        passwordInput.addEventListener('change', validatePassword);
        confirmPasswordInput.addEventListener('keyup', checkPasswordMatch);
        confirmPasswordInput.addEventListener('change', checkPasswordMatch);

        // Initial validation
        validatePassword();
    });
</script>
@endsection
