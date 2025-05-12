{{-- resources/views/users/form.blade.php --}}
@csrf
<div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" name="username" class="form-control" value="{{ old('username', $user->username ?? '') }}">
</div>
<div class="mb-3">
    <label for="fullname" class="form-label">Fullname</label>
    <input type="text" name="fullname" class="form-control" value="{{ old('fullname', $user->fullname ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="phone" class="form-label">Phone</label>
    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="address" class="form-label">Address</label>
    <input type="text" name="address" class="form-control" value="{{ old('address', $user->address ?? '') }}" required>
</div>

@if(!isset($user) || auth()->user()->isAdmin())
<div class="mb-3">
    <label for="role" class="form-label">Role</label>
    <select name="role" class="form-select" required>
        <option value="user" {{ (old('role', $user->role ?? '') == 'user') ? 'selected' : '' }}>User</option>
        <option value="saler" {{ (old('role', $user->role ?? '') == 'saler') ? 'selected' : '' }}>Saler</option>
        @if(auth()->user()->isAdmin())
        <option value="admin" {{ (old('role', $user->role ?? '') == 'admin') ? 'selected' : '' }}>Admin</option>
        @endif
    </select>
</div>
@endif

<div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
           {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Active</label>
</div>

<div class="mb-3">
    <label for="password" class="form-label">Password{{ isset($user) ? ' (leave blank to keep current)' : '' }}</label>
    <input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
</div>
<div class="mb-3">
    <label for="password_confirmation" class="form-label">Confirm Password</label>
    <input type="password" name="password_confirmation" class="form-control" {{ isset($user) ? '' : 'required' }}>
</div>
