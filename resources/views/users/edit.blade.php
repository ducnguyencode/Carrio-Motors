@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg my-5">
                    <div class="card-header text-white py-3" style="background: linear-gradient(to right, #4f46e5, #0ea5e9);">
                        <h2 class="mb-0 fw-bold">Edit User</h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @include('users.form')

                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="saler" {{ $user->role == 'saler' ? 'selected' : '' }}>Saler</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary py-2" style="background: linear-gradient(to right, #4f46e5, #0ea5e9); border: none;">
                                    Update User
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

