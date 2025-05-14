@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('page-heading', 'Edit User')

@section('content')
<div class="bg-white rounded-2xl shadow-xl p-10 max-w-2xl mx-auto mt-6">
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Username -->
            <div class="relative">
                <label for="username" class="absolute left-4 top-2 text-gray-400 pointer-events-none transition-all duration-200"> <i class="fas fa-user mr-1"></i> Username *</label>
                <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" class="w-full pt-7 pb-2 px-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base bg-gray-50 shadow-sm @error('username') border-red-500 @enderror" required autocomplete="off">
                @error('username')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <!-- Full Name -->
            <div class="relative">
                <label for="fullname" class="absolute left-4 top-2 text-gray-400 pointer-events-none transition-all duration-200"> <i class="fas fa-id-card mr-1"></i> Full Name *</label>
                <input type="text" name="fullname" id="fullname" value="{{ old('fullname', $user->fullname) }}" class="w-full pt-7 pb-2 px-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base bg-gray-50 shadow-sm @error('fullname') border-red-500 @enderror" required autocomplete="off">
                @error('fullname')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <!-- Email -->
            <div class="relative">
                <label for="email" class="absolute left-4 top-2 text-gray-400 pointer-events-none transition-all duration-200"> <i class="fas fa-envelope mr-1"></i> Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full pt-7 pb-2 px-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base bg-gray-50 shadow-sm @error('email') border-red-500 @enderror" required autocomplete="off">
                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <!-- Phone -->
            <div class="relative">
                <label for="phone" class="absolute left-4 top-2 text-gray-400 pointer-events-none transition-all duration-200"> <i class="fas fa-phone mr-1"></i> Phone</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="w-full pt-7 pb-2 px-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base bg-gray-50 shadow-sm @error('phone') border-red-500 @enderror" autocomplete="off">
                @error('phone')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <!-- Address -->
            <div class="relative">
                <label for="address" class="absolute left-4 top-2 text-gray-400 pointer-events-none transition-all duration-200"> <i class="fas fa-map-marker-alt mr-1"></i> Address</label>
                <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}" class="w-full pt-7 pb-2 px-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base bg-gray-50 shadow-sm @error('address') border-red-500 @enderror" autocomplete="off">
                @error('address')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <!-- Password -->
            <div class="relative">
                <label for="password" class="absolute left-4 top-2 text-gray-400 pointer-events-none transition-all duration-200"> <i class="fas fa-lock mr-1"></i> Password</label>
                <input type="password" name="password" id="password" class="w-full pt-7 pb-2 px-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base bg-gray-50 shadow-sm @error('password') border-red-500 @enderror" autocomplete="off">
                <div class="flex">
                    <span class="text-xs text-gray-500 mt-1"><i class="fas fa-info-circle mr-1"></i> Leave blank to keep current password</span>
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <!-- Password Confirmation -->
            <div class="relative">
                <label for="password_confirmation" class="absolute left-4 top-2 text-gray-400 pointer-events-none transition-all duration-200"> <i class="fas fa-lock mr-1"></i> Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full pt-7 pb-2 px-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base bg-gray-50 shadow-sm" autocomplete="off">
            </div>
            <!-- Role -->
            <div class="relative">
                <label for="role" class="absolute left-4 top-2 text-gray-400 pointer-events-none transition-all duration-200"> <i class="fas fa-user-tag mr-1"></i> Role *</label>
                @php
                    $adminExists = \App\Models\User::where('role', 'admin')->count() > 0;
                    $isOnlyAdmin = $user->role === 'admin' && $adminExists;
                @endphp
                @if($isOnlyAdmin)
                    <input type="hidden" name="role" value="admin">
                    <input type="text" class="w-full pt-7 pb-2 px-4 rounded-xl border border-gray-300 bg-gray-100 text-base shadow-sm cursor-not-allowed" value="Admin" readonly disabled>
                    <p class="mt-1 text-xs text-gray-500"><i class="fas fa-info-circle"></i> This is the only admin account and cannot be changed to another role.</p>
                @else
                    <select name="role" id="role" class="w-full pt-7 pb-2 px-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base bg-gray-50 shadow-sm @error('role') border-red-500 @enderror" required>
                        <option value="">Select Role</option>
                        @if($user->role == 'admin' || !$adminExists)
                        <option value="admin" {{ (old('role', $user->role) == 'admin') ? 'selected' : '' }}>Admin</option>
                        @endif
                        <option value="content" {{ (old('role', $user->role) == 'content') ? 'selected' : '' }}>Content</option>
                        <option value="saler" {{ (old('role', $user->role) == 'saler') ? 'selected' : '' }}>Saler</option>
                        <option value="user" {{ (old('role', $user->role) == 'user') ? 'selected' : '' }}>User</option>
                    </select>
                @endif
                @error('role')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <!-- Is Active -->
            <div class="flex items-center mt-8">
                <input type="checkbox" name="is_active" id="is_active" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-2" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="block text-base text-gray-700">Active Account</label>
            </div>
        </div>
        <div class="flex justify-end gap-2 mt-8">
            <a href="{{ route('admin.users.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-blue-700 text-white hover:from-blue-600 hover:to-blue-800 font-semibold shadow transition">Update User</button>
        </div>
    </form>
</div>
@endsection
