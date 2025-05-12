@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col-lg-6">
            <h1 class="display-5 fw-bold text-primary mb-0">User Profile</h1>
        </div>
        <div class="col-lg-6 text-lg-end">
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
            @if(auth()->id() === $user->id || auth()->user()->isAdmin())
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit Profile
            </a>
            @endif
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success shadow-sm border-0">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger shadow-sm border-0">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
    </div>
    @endif

    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        <div class="card-header bg-gradient-primary text-white p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ $user->fullname }}</h4>
                <div>
                    <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : ($user->role === 'saler' ? 'bg-warning' : 'bg-info') }} rounded-pill px-3 py-2 fs-6">
                        {{ ucfirst($user->role) }}
                    </span>
                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }} rounded-pill px-3 py-2 fs-6 ms-2">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="p-4 bg-light rounded-3 h-100">
                        <h5 class="border-bottom pb-3 mb-4"><i class="fas fa-user me-2"></i> Personal Information</h5>
                        <div class="mb-3">
                            <div class="text-muted small">Username</div>
                            <div class="fw-bold fs-5">{{ $user->username }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted small">Full Name</div>
                            <div class="fw-bold fs-5">{{ $user->fullname }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted small">Email</div>
                            <div class="fw-bold fs-5">
                                <a href="mailto:{{ $user->email }}" class="text-decoration-none">{{ $user->email }}</a>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted small">Phone</div>
                            <div class="fw-bold fs-5">
                                <a href="tel:{{ $user->phone }}" class="text-decoration-none">{{ $user->phone }}</a>
                            </div>
                        </div>
                        <div>
                            <div class="text-muted small">Address</div>
                            <div class="fw-bold fs-5">{{ $user->address }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    @if(auth()->user()->isAdmin())
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-shield-alt me-2"></i> Admin Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="text-muted small">Account created</div>
                                <div class="fw-bold">{{ $user->created_at->format('M d, Y H:i') }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted small">Last updated</div>
                                <div class="fw-bold">{{ $user->updated_at->format('M d, Y H:i') }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted small">Account role</div>
                                <div class="fw-bold">
                                    <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : ($user->role === 'saler' ? 'bg-warning' : 'bg-info') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                            </div>

                            @if(!$user->is_active && auth()->user()->isAdmin() && auth()->id() !== $user->id)
                            <div class="mt-4">
                                <form action="{{ route('users.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="is_active" value="1">
                                    <input type="hidden" name="username" value="{{ $user->username }}">
                                    <input type="hidden" name="fullname" value="{{ $user->fullname }}">
                                    <input type="hidden" name="email" value="{{ $user->email }}">
                                    <input type="hidden" name="phone" value="{{ $user->phone }}">
                                    <input type="hidden" name="address" value="{{ $user->address }}">
                                    <input type="hidden" name="role" value="{{ $user->role }}">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-user-check me-1"></i> Reactivate Account
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-car me-2"></i> Activity</h5>
                        </div>
                        <div class="card-body text-center py-5">
                            <div class="display-1 text-muted mb-3">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h5>Account Activity</h5>
                            <p class="text-muted">View your account activity and recent purchases</p>
                            <a href="{{ route('user.purchases') }}" class="btn btn-outline-primary">
                                <i class="fas fa-shopping-cart me-1"></i> View Purchases
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
