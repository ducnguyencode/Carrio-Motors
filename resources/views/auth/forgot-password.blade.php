@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg mt-5">
                <!-- Header -->
                <div class="card-header text-white py-4" style="background: linear-gradient(to right, #4f46e5, #0ea5e9);">
                    <h2 class="text-center mb-1 fw-bold">Reset Your Password</h2>
                    <p class="text-center mb-0 small">
                        Enter your email to receive a password reset link
                    </p>
                </div>

                <!-- Form Section -->
                <div class="card-body p-5">
                    @if (session('status'))
                        <div class="alert alert-success mb-4">
                            <strong>Success!</strong>
                            <p class="mb-0">{{ session('status') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="Enter your registered email">
                            </div>
                            @error('email')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit"
                                class="btn btn-primary w-100 py-2 mb-4" style="background: linear-gradient(to right, #4f46e5, #0ea5e9); border: none;">
                            Send Password Reset Link
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ url('/admin') }}" class="text-decoration-none d-inline-flex align-items-center">
                            <i class="fas fa-arrow-left me-1 small"></i>
                            Back to Login
                        </a>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="fw-bold mb-2">Having trouble?</h6>
                        <p class="text-muted small mb-0">
                            If you're still having trouble resetting your password, please contact customer support at
                            <a href="mailto:support@carriomotors.com" class="text-decoration-none">support@carriomotors.com</a>
                        </p>
                        <hr class="my-2">
                        <p class="text-muted small mb-0">
                            <i class="fas fa-info-circle me-1"></i> Remember: You can always log in using your email address instead of your username.
                        </p>
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
</style>
@endsection
