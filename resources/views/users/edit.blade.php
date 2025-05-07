<x-app-layout>
    <div class="container">
        <h1>Edit User</h1>
        <div class="mb-3">
          <label for="role" class="form-label">Phân quyền</label>
          <select name="role" id="role" class="form-control">
            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
            <option value="saler" {{ $user->role == 'saler' ? 'selected' : '' }}>Saler</option>
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
          </select>
        </div>
    </div>
</x-app-layout>

