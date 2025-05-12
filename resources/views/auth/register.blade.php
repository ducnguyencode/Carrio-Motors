@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-lg mt-4">
                <div class="card-body p-0">
                    <div class="row">
                        <!-- Left side - Form -->
                        <div class="col-md-8 p-5">
                            <h2 class="fw-bold mb-1">Create an Account</h2>
                            <p class="text-muted mb-4">Join Carrio Motors and explore our exclusive collection</p>

                            @if (session('error'))
                                <div class="alert alert-danger mb-4">
                                    <strong>Error!</strong>
                                    <p class="mb-0">{{ session('error') }}</p>
                                </div>
                            @endif

                            @if(isset($isFirstUser) && $isFirstUser)
                                <div class="alert alert-primary mb-4">
                                    <strong>First User Registration</strong>
                                    <p class="mb-0">You'll be assigned as the system administrator with full access.</p>
                                </div>
                            @endif

                            <form method="POST" action="{{ url('/register') }}">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">
                                                <i class="fas fa-user text-muted"></i>
                                            </span>
                                            <input id="username" name="username" type="text" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required placeholder="Choose a username">
                                        </div>
                                        @error('username')
                                            <div class="text-danger mt-1 small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="fullname" class="form-label">Full Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">
                                                <i class="fas fa-id-card text-muted"></i>
                                            </span>
                                            <input id="fullname" name="fullname" type="text" class="form-control @error('fullname') is-invalid @enderror" value="{{ old('fullname') }}" required placeholder="Enter your full name">
                                        </div>
                                        @error('fullname')
                                            <div class="text-danger mt-1 small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">
                                                <i class="fas fa-envelope text-muted"></i>
                                            </span>
                                            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="Enter your email">
                                        </div>
                                        @error('email')
                                            <div class="text-danger mt-1 small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">
                                                <i class="fas fa-phone-alt text-muted"></i>
                                            </span>
                                            <input id="phone" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required placeholder="Enter your phone number">
                                        </div>
                                        @error('phone')
                                            <div class="text-danger mt-1 small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-map-marker-alt text-muted"></i>
                                        </span>
                                        <input id="address" name="address" type="text" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" required placeholder="Enter your address">
                                    </div>
                                    @error('address')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">
                                                <i class="fas fa-lock text-muted"></i>
                                            </span>
                                            <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Create a password">
                                        </div>
                                        @error('password')
                                            <div class="text-danger mt-1 small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">
                                                <i class="fas fa-lock text-muted"></i>
                                            </span>
                                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required placeholder="Confirm your password">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-2 mb-4" style="background: linear-gradient(to right, #4f46e5, #0ea5e9); border: none;">
                                    Create Account
                                </button>

                                <div class="text-center">
                                    <p class="mb-0">
                                        Already have an account?
                                        <a href="{{ url('/login') }}" class="text-decoration-none">Sign in</a>
                                    </p>
                                </div>
                            </form>
                        </div>

                        <!-- Right side - Image -->
                        <div class="col-md-4 d-none d-md-block p-0">
                            <div class="bg-image h-100" style="background-image: url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1400&q=80'); background-size: cover; background-position: center; border-radius: 0 5px 5px 0;">
                                <div class="h-100 d-flex align-items-end p-4" style="background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));">
                                    <div class="text-white pb-4">
                                        <h3 class="fw-bold mb-3">Carrio Motors</h3>
                                        <p>Join our community of car enthusiasts and gain access to premium vehicles.</p>
                                    </div>
                                </div>
                            </div>
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
</style>
@endsection
