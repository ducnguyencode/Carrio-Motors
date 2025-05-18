@extends('admin.layouts.app')

@section('title', 'Create Banner')

@section('page-heading', 'Create New Banner')

@section('styles')
<style>
    :root {
        --primary-color: #4f46e5;
        --primary-hover: #4338ca;
        --primary-light: rgba(79, 70, 229, 0.1);
        --secondary-color: #f97316;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --success-color: #10b981;
        --danger-color: #ef4444;
        --border-color: #e2e8f0;
        --container-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.1);
        --input-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        --card-bg: #ffffff;
        --body-bg: #f1f5f9;
        --transition-normal: all 0.3s ease;
    }

    body {
        background-color: var(--body-bg);
    }

    .form-card {
        border-radius: 16px;
        box-shadow: var(--container-shadow);
        transition: var(--transition-normal);
        border: 1px solid var(--border-color);
        overflow: hidden;
        background: var(--card-bg);
    }

    .form-card:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .card-header {
        background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
        padding: 1.5rem 2rem;
        color: white;
        position: relative;
    }

    .card-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
        z-index: 10;
        position: relative;
    }

    .card-header::after {
        content: '';
        position: absolute;
        right: -20px;
        bottom: -20px;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .card-header::before {
        content: '';
        position: absolute;
        left: -20px;
        top: -20px;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .card-body {
        padding: 2rem;
    }

    .form-section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        letter-spacing: -0.025em;
    }

    .section-title i {
        margin-right: 0.75rem;
        color: var(--primary-color);
        font-size: 1.35rem;
    }

    .input-group {
        margin-bottom: 1.5rem;
    }

    .input-group:last-child {
        margin-bottom: 0;
    }

    .input-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
        font-size: 0.95rem;
    }

    .required-mark {
        color: var(--danger-color);
        margin-left: 0.25rem;
    }

    .input-group input[type="text"],
    .input-group input[type="number"],
    .input-group input[type="email"],
    .input-group input[type="password"],
    .input-group textarea,
    .input-group select {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        border: 1px solid var(--border-color);
        box-shadow: var(--input-shadow);
        transition: var(--transition-normal);
        font-size: 1rem;
        background-color: #fcfcfc;
    }

    .input-group input[type="text"]:focus,
    .input-group input[type="number"]:focus,
    .input-group input[type="email"]:focus,
    .input-group input[type="password"]:focus,
    .input-group textarea:focus,
    .input-group select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        outline: none;
    }

    .input-group input[type="text"]::placeholder,
    .input-group input[type="number"]::placeholder,
    .input-group input[type="email"]::placeholder,
    .input-group input[type="password"]::placeholder,
    .input-group textarea::placeholder {
        color: #94a3b8;
    }

    .help-text {
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: var(--text-secondary);
        line-height: 1.4;
    }

    .error-text {
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: var(--danger-color);
        font-weight: 500;
    }

    .alert {
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    .alert-success {
        background-color: #ecfdf5;
        border-left: 4px solid var(--success-color);
        color: #065f46;
    }

    .alert-danger {
        background-color: #fef2f2;
        border-left: 4px solid var(--danger-color);
        color: #991b1b;
    }

    .alert-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(to right, var(--primary-color), var(--primary-hover));
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        color: white;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px rgba(79, 70, 229, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px rgba(79, 70, 229, 0.3);
    }

    .btn-primary:active {
        transform: translateY(-1px);
    }

    .btn-secondary {
        background-color: #f8fafc;
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition-normal);
    }

    .btn-secondary:hover {
        background-color: #f1f5f9;
    }

    .custom-file-input {
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .custom-file-input input[type="file"] {
        padding: 0.75rem;
        border-radius: 0.5rem;
        border: 1px solid var(--border-color);
        background-color: #fcfcfc;
        transition: var(--transition-normal);
        cursor: pointer;
    }

    .custom-file-input input[type="file"]:hover {
        background-color: var(--primary-light);
    }

    .file-meta {
        display: flex;
        justify-content: space-between;
        margin-top: 0.5rem;
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    .switch-container {
        display: flex;
        align-items: center;
    }

    /* Toggle Switch */
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
        margin-right: 0.75rem;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e1;
        transition: .4s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: var(--primary-color);
    }

    input:focus + .slider {
        box-shadow: 0 0 1px var(--primary-color);
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    .checkbox-label {
        font-weight: 600;
        color: var(--text-primary);
        cursor: pointer;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    @media (min-width: 768px) {
        .form-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .radio-group {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 0.5rem;
    }

    .radio-option {
        flex: 1;
        min-width: 150px;
    }

    .radio-option-inner {
        padding: 1rem;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        cursor: pointer;
        transition: var(--transition-normal);
        background-color: white;
        position: relative;
        display: flex;
        align-items: center;
    }

    .radio-option-inner:hover {
        border-color: var(--primary-color);
        background-color: var(--primary-light);
    }

    .radio-option input[type="radio"] {
        margin-right: 0.75rem;
        accent-color: var(--primary-color);
        width: 1.25rem;
        height: 1.25rem;
    }

    .radio-option input[type="radio"]:checked + .radio-label {
        color: var(--primary-color);
        font-weight: 600;
    }

    .radio-option input[type="radio"]:checked ~ .radio-option-inner {
        border-color: var(--primary-color);
        background-color: var(--primary-light);
    }

    /* Animation for cards */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-card {
        animation: fadeIn 0.6s ease forwards;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
    }

    #video_upload_section, #existing_video_section {
        transition: var(--transition-normal);
        overflow: hidden;
        max-height: 300px;
        opacity: 1;
    }

    #video_upload_section.hidden, #existing_video_section.hidden {
        max-height: 0;
        opacity: 0;
        margin: 0;
        padding: 0;
    }
</style>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 max-w-5xl mx-auto">
    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        @if (session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-700">Please check the following errors:</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Banner Content Section -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
                Banner Content
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('title') border-red-500 @enderror" value="{{ old('title') }}" placeholder="e.g. Luxury Sports Car">
                    @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="main_content" class="block text-sm font-semibold text-gray-700 mb-1">Main Content <span class="text-red-500">*</span></label>
                    <textarea id="main_content" name="main_content" rows="2" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('main_content') border-red-500 @enderror" placeholder="e.g. Experience the thrill of driving perfection">{{ old('main_content') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">This text appears under the title in the banner slideshow</p>
                    @error('main_content')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Display Settings Section -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                </svg>
                Display Settings
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="position" class="block text-sm font-semibold text-gray-700 mb-1">Display Position</label>
                    <input type="number" id="position" name="position" min="0" step="1" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('position') border-red-500 @enderror" value="{{ old('position', 0) }}">
                    <p class="mt-1 text-sm text-gray-500">Lower numbers appear first in the slideshow. Use 0 for default ordering.</p>
                    @error('position')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="car_id" class="block text-sm font-semibold text-gray-700 mb-1">Link to Car</label>
                    <select id="car_id" name="car_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('car_id') border-red-500 @enderror">
                        <option value="">Select a car</option>
                        @foreach($cars as $car)
                            <option value="{{ $car->id }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>
                                {{ $car->name }} ({{ $car->brand }})
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-sm text-gray-500">When selected, clicking the banner will go to this car's details page</p>
                    @error('car_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="click_url" class="block text-sm font-semibold text-gray-700 mb-1">Custom Click URL</label>
                    <input type="text" id="click_url" name="click_url" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('click_url') border-red-500 @enderror" value="{{ old('click_url') }}" placeholder="https://example.com/special-promotion">
                    <p class="mt-1 text-sm text-gray-500">If provided, clicking on the banner will redirect to this URL instead of the linked car page</p>
                    @error('click_url')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Video Section -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                </svg>
                Video
            </h3>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Video Source <span class="text-red-500">*</span></label>
                <div class="flex gap-4">
                    <div class="flex items-center">
                        <input type="radio" id="video_type_upload" name="video_type" value="upload" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ old('video_type', 'upload') === 'upload' ? 'checked' : '' }} onchange="toggleVideoSource()">
                        <label for="video_type_upload" class="ml-2 block text-sm text-gray-700">Upload New Video</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="video_type_existing" name="video_type" value="existing" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ old('video_type') === 'existing' ? 'checked' : '' }} onchange="toggleVideoSource()">
                        <label for="video_type_existing" class="ml-2 block text-sm text-gray-700">Use Existing Video</label>
                    </div>
                </div>
            </div>

            <div id="video_upload_section" class="{{ old('video_type') === 'existing' ? 'hidden' : '' }}">
                <label for="video" class="block text-sm font-semibold text-gray-700 mb-1">Upload Video File <span class="text-red-500">*</span></label>
                <input type="file" id="video" name="video" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('video') border-red-500 @enderror" accept="video/mp4,video/avi,video/mov">
                <p class="mt-1 text-sm text-gray-500 flex justify-between">
                    <span>Supported: MP4, AVI, MOV</span>
                    <span>Max size: 1GB</span>
                </p>
                @error('video')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div id="existing_video_section" class="{{ old('video_type', 'upload') === 'upload' ? 'hidden' : '' }}">
                <label for="existing_video" class="block text-sm font-semibold text-gray-700 mb-1">Select Existing Video <span class="text-red-500">*</span></label>
                <select id="existing_video" name="existing_video" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('existing_video') border-red-500 @enderror">
                    <option value="">Select a video</option>
                    <option value="video1.mp4" {{ old('existing_video') === 'video1.mp4' ? 'selected' : '' }}>Video 1</option>
                    <option value="video2.mp4" {{ old('existing_video') === 'video2.mp4' ? 'selected' : '' }}>Video 2</option>
                    <option value="video3.mp4" {{ old('existing_video') === 'video3.mp4' ? 'selected' : '' }}>Video 3</option>
                </select>
                @error('existing_video')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Banner Status Section -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 2a6 6 0 100 12 6 6 0 000-12zm-1 9a1 1 0 112 0v-2a1 1 0 11-2 0v2zm0-6a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd" />
                </svg>
                Banner Status
            </h3>

            <div class="flex items-center">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-2">
                <label for="is_active" class="text-base text-gray-700">Make banner active</label>
                <p class="mt-1 ml-7 text-sm text-gray-500">Only active banners will appear in the slideshow</p>
                @error('is_active')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-8">
            <a href="{{ route('admin.banners.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-semibold shadow transition">
                Create Banner
            </button>
        </div>
    </form>
</div>

<script>
function toggleVideoSource() {
    const uploadType = document.getElementById('video_type_upload');
    const uploadSection = document.getElementById('video_upload_section');
    const existingSection = document.getElementById('existing_video_section');

    if (uploadType.checked) {
        uploadSection.classList.remove('hidden');
        existingSection.classList.add('hidden');
    } else {
        uploadSection.classList.add('hidden');
        existingSection.classList.remove('hidden');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleVideoSource();
});
</script>
@endsection
