@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Danh sách Users</h1>
  <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Thêm mới</a>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th><th>Username</th><th>Fullname</th><th>Email</th><th>Active</th><th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
      <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->username }}</td>
        <td>{{ $user->fullname }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->is_active ? '✔' : '✖' }}</td>
        <td>
          <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-info">Xem</a>
          <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">Sửa</a>
          <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger"
                    onclick="return confirm('Chắc chắn vô hiệu hóa?')">Xóa</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{ $users->links() }}
</div>
@endsection
