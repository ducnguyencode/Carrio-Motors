{{-- resources/views/users/form.blade.php --}}
@csrf
<div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" name="username" class="form-control" value="{{ old('username') }}">
</div>
<div class="mb-3">
    <label for="fullname" class="form-label">Fullname</label>
    <input type="text" name="fullname" class="form-control" value="{{ old('fullname') }}" required>
</div>
<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
</div>
<div class="mb-3">
    <label for="phone" class="form-label">Phone</label>
    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
</div>
<div class="mb-3">
    <label for="address" class="form-label">Address</label>
    <input type="text" name="address" class="form-control" value="{{ old('address') }}" required>
</div>
<div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" required>
</div>
<div class="mb-3">
    <label for="password_confirmation" class="form-label">Confirm Password</label>
    <input type="password" name="password_confirmation" class="form-control" required>
</div>