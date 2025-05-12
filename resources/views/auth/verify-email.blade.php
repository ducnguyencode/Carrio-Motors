@extends('layouts.app')

@section('title', 'Verify Your Email Address')

@section('content')
<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="card shadow-lg p-4" style="max-width: 500px; width: 100%;">
        <div class="text-center mb-4">
            <i class="fas fa-envelope fa-3x text-primary mb-3"></i>
            <h2 class="mb-2">Verify Your Email Address</h2>
        </div>
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                A new verification link has been sent to your email address.
            </div>
        @endif
        <p class="mb-3">Thank you for registering! Before getting started, please check your email for a verification link. If you did not receive the email, click the button below to request another.</p>
        <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary w-100">Resend Verification Email</button>
        </form>
        <div class="mt-3 text-center">
            <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection
