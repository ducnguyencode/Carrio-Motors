@extends('layouts.app')
@section('content')
<div class="container">
  <h1>Thêm User</h1>
  <form action="{{ route('users.store') }}" method="POST">
    @include('users.form')
    <div class="mb-3">
      <label for="role" class="form-label">Phân quyền</label>
      <select name="role" id="role" class="form-control">
        <option value="user">User</option>
        <option value="saler">Saler</option>
        <option value="admin">Admin</option>
      </select>
    </div>
  </form>
</div>
@endsection
