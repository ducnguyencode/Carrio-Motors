@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Edit Banner</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="main_content" class="form-label">Main Content</label>
                            <textarea id="main_content" name="main_content" rows="3" class="form-control @error('main_content') is-invalid @enderror" required>{{ old('main_content', $banner->main_content) }}</textarea>
                            @error('main_content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="car_id" class="form-label">Link to Car</label>
                            <select id="car_id" name="car_id" class="form-select @error('car_id') is-invalid @enderror" required>
                                <option value="">Select a car</option>
                                @foreach($cars as $car)
                                    <option value="{{ $car->id }}" {{ (old('car_id', $banner->car_id) == $car->id) ? 'selected' : '' }}>
                                        {{ $car->name }} ({{ $car->brand }})
                                    </option>
                                @endforeach
                            </select>
                            @error('car_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($banner->video_url)
                            <div class="mb-3">
                                <label class="form-label">Current Video</label>
                                <div class="mb-2">
                                    <video width="320" height="180" controls>
                                        <source src="{{ Storage::url($banner->video_url) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="video" class="form-label">{{ $banner->video_url ? 'Replace Video' : 'Video File' }}</label>
                            <input type="file" id="video" name="video" class="form-control @error('video') is-invalid @enderror" accept="video/mp4,video/avi,video/mov">
                            <div class="form-text">Supported formats: MP4, AVI, MOV. Max size: 100MB</div>
                            @error('video')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ (old('is_active', $banner->is_active)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Make banner active</label>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Banner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
