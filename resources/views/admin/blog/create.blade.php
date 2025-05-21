@extends('admin.layouts.app')

@section('title', 'Create Blog Post')
@section('page-heading', 'Create New Blog Post')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .ck-editor__editable_inline {
        min-height: 400px;
    }

    .content-container {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 1.5rem;
    }

    @media (max-width: 1024px) {
        .content-container {
            grid-template-columns: 1fr;
        }
    }

    .card {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 1.25rem;
    }

    .card-header {
        padding-left: 1.25rem;
        padding-right: 1.25rem;
        padding-top: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(243, 244, 246, 1);
        display: flex;
        align-items: center;
    }

    .card-body {
        padding: 1.25rem;
    }

    .section-icon {
        margin-right: 0.5rem;
        color: #3b82f6;
        width: 1.25rem;
        height: 1.25rem;
        flex-shrink: 0;
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.25rem;
    }

    .form-input {
        width: 100%;
        border-radius: 0.375rem;
        border: 1px solid #d1d5db;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    .form-input:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    .form-input-lg {
        font-size: 1.125rem;
        font-weight: 500;
    }

    .image-upload-area {
        margin-top: 0.25rem;
        display: flex;
        justify-content: center;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
        padding-top: 1.25rem;
        padding-bottom: 1.5rem;
        border: 2px solid #d1d5db;
        border-style: dashed;
        border-radius: 0.375rem;
        cursor: pointer;
    }

    .image-upload-area:hover {
        background-color: #f9fafb;
        transition: background-color 0.2s;
    }

    .image-preview {
        margin-top: 0.75rem;
        position: relative;
        border-radius: 0.375rem;
        overflow: hidden;
    }

    .tag-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .tag-item {
        background-color: #f3f4f6;
        color: #1f2937;
        font-size: 0.75rem;
        border-radius: 9999px;
        padding-left: 0.75rem;
        padding-right: 0.75rem;
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
        display: flex;
        align-items: center;
    }

    .tag-remove {
        margin-left: 0.5rem;
        color: #6b7280;
        cursor: pointer;
    }

    .tag-remove:hover {
        color: #ef4444;
    }

    .btn-primary {
        background-color: #2563eb;
        color: white;
        font-weight: 500;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        padding-left: 1rem;
        padding-right: 1rem;
        border-radius: 0.375rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        transition: all 0.2s;
    }

    .btn-primary:hover {
        background-color: #1d4ed8;
    }

    .btn-secondary {
        background-color: white;
        border: 1px solid #d1d5db;
        color: #374151;
        font-weight: 500;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        padding-left: 1rem;
        padding-right: 1rem;
        border-radius: 0.375rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        transition: all 0.2s;
    }

    .btn-secondary:hover {
        background-color: #f9fafb;
    }
</style>
@endsection

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.blog.index') }}" class="inline-flex items-center text-blue-600 hover:underline">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Blog Posts
    </a>
</div>

@if ($errors->any())
<div class="bg-red-50 border-l-4 border-red-500 p-4 mb-5 rounded">
    <div class="flex items-start">
        <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
            <h3 class="text-red-800 font-medium">There were errors with your submission</h3>
            <ul class="mt-1 ml-5 list-disc text-sm text-red-700">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" id="blogForm">
    @csrf

    <div class="content-container">
        <!-- Main Content Column -->
        <div>
            <!-- Title Card -->
            <div class="card">
                <div class="card-body">
                    <label for="title" class="form-label">Title <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}"
                           class="form-input form-input-lg"
                           placeholder="Enter blog post title" required>
                </div>
            </div>

            <!-- Excerpt Card -->
            <div class="card">
                <div class="card-header">
                    <svg class="section-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                    </svg>
                    <h2 class="text-lg font-medium">Post Excerpt</h2>
                </div>
                <div class="card-body">
                    <label for="excerpt" class="form-label">Excerpt (Summary)</label>
                    <textarea id="excerpt" name="excerpt" rows="3"
                              class="form-input"
                              placeholder="Write a brief summary of your blog post...">{{ old('excerpt') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">
                        This will be displayed in blog listings and previews (max 500 characters)
                    </p>
                </div>
            </div>

            <!-- Content Card -->
            <div class="card">
                <div class="card-header">
                    <svg class="section-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                    </svg>
                    <h2 class="text-lg font-medium">Content <span class="text-red-500">*</span></h2>
                </div>
                <div class="card-body">
                    <textarea id="editor" name="content">{{ old('content') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div>
            <!-- Publish Settings Card -->
            <div class="card">
                <div class="card-header">
                    <svg class="section-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <h2 class="text-lg font-medium">Publish</h2>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-input">
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>

                    <div class="flex justify-between space-x-2 mt-6">
                        <a href="{{ route('admin.blog.index') }}" class="btn-secondary flex-1 text-center">Cancel</a>
                        <button type="submit" class="btn-primary flex-1">Publish Post</button>
                    </div>
                </div>
            </div>

            <!-- Featured Image Card -->
            <div class="card">
                <div class="card-header">
                    <svg class="section-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3.001 6z" clip-rule="evenodd" />
                    </svg>
                    <h2 class="text-lg font-medium">Featured Image</h2>
                </div>
                <div class="card-body">
                    <label class="form-label">Upload Image</label>
                    <div class="image-upload-area" onclick="document.getElementById('featured_image').click();">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <span class="relative rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                    Upload an image
                                </span>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PNG, JPG, GIF up to 2MB
                            </p>
                        </div>
                    </div>
                    <input id="featured_image" name="featured_image" type="file" accept="image/*" class="sr-only" onchange="previewImage(this);">

                    <div id="image-preview" class="image-preview hidden">
                        <img src="" alt="Preview" class="w-full h-auto">
                        <button type="button" onclick="removeImage()" class="absolute top-2 right-2 bg-white rounded-full p-1 shadow">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Categories & Tags Card -->
            <div class="card">
                <div class="card-header">
                    <svg class="section-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                    <h2 class="text-lg font-medium">Categories & Tags</h2>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" id="category" name="category" value="{{ old('category') }}"
                               class="form-input"
                               placeholder="E.g. Car Reviews, Maintenance">
                    </div>

                    <div>
                        <label for="tag-input" class="form-label">Tags</label>
                        <div class="flex">
                            <input type="text" id="tag-input"
                                   class="form-input rounded-r-none"
                                   placeholder="Add tag and press Enter">
                            <button type="button" onclick="addTag()"
                                    class="px-3 border border-l-0 border-gray-300 rounded-r-md bg-gray-50 text-gray-500 hover:bg-gray-100">
                                Add
                            </button>
                        </div>
                        <input type="hidden" id="tags" name="tags" value="{{ old('tags') }}">
                        <div id="tag-container" class="tag-container">
                            <!-- Tags will be added here dynamically -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize CKEditor with image upload functionality
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', '|', 'bulletedList', 'numberedList', '|', 'indent', 'outdent', '|', 'imageUpload', 'blockQuote', 'insertTable', 'mediaEmbed', 'undo', 'redo'],
                simpleUpload: {
                    // The URL that the images are uploaded to.
                    uploadUrl: '{{ route("admin.upload.image") }}',
                    // Headers sent along with the XMLHttpRequest to the upload server.
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            })
            .catch(error => {
                console.error(error);
            });

        // Handle tags
        const tagsInput = document.getElementById('tags');
        const tagInput = document.getElementById('tag-input');
        const tagContainer = document.getElementById('tag-container');

        let tags = [];

        // Load any existing tags
        if (tagsInput.value) {
            try {
                tags = JSON.parse(tagsInput.value);
                renderTags();
            } catch (e) {
                console.error('Error parsing tags', e);
            }
        }

        // Add tag when enter key is pressed
        tagInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addTag();
            }
        });

        // Expose the addTag function to the global scope
        window.addTag = function() {
            const tag = tagInput.value.trim();
            if (tag && !tags.includes(tag)) {
                tags.push(tag);
                tagsInput.value = JSON.stringify(tags);
                tagInput.value = '';
                renderTags();
            }
        };

        // Render the tags
        function renderTags() {
            tagContainer.innerHTML = '';
            tags.forEach((tag, index) => {
                const tagElement = document.createElement('div');
                tagElement.className = 'tag-item';
                tagElement.innerHTML = `
                    ${tag}
                    <span class="tag-remove" onclick="removeTag(${index})">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </span>
                `;
                tagContainer.appendChild(tagElement);
            });
        }

        // Expose the removeTag function to the global scope
        window.removeTag = function(index) {
            tags.splice(index, 1);
            tagsInput.value = JSON.stringify(tags);
            renderTags();
        };
    });

    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const img = preview.querySelector('img');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                img.src = e.target.result;
                preview.classList.remove('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage() {
        const preview = document.getElementById('image-preview');
        const input = document.getElementById('featured_image');

        preview.classList.add('hidden');
        input.value = '';
    }
</script>
@endpush
