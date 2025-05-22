@extends('admin.layouts.app')

@section('title', 'Edit Blog Post')
@section('page-heading', 'Edit Blog Post')

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

    .current-image {
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

    .info-badge {
        display: flex;
        align-items: center;
        background-color: #f9fafb;
        padding: 0.75rem;
        border-radius: 0.375rem;
        margin-bottom: 0.5rem;
    }

    .info-badge-icon {
        color: #3b82f6;
        margin-right: 0.75rem;
        flex-shrink: 0;
    }

    .info-badge-content {
        flex: 1;
    }

    .info-label {
        font-size: 0.75rem;
        color: #6b7280;
        margin-bottom: 0.125rem;
    }

    .info-value {
        font-size: 0.875rem;
        font-weight: 500;
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

<form action="{{ route('admin.blog.update', $post->id) }}" method="POST" enctype="multipart/form-data" id="blogForm">
    @csrf
    @method('PUT')

    <div class="content-container">
        <!-- Main Content Column -->
        <div>
            <!-- Title Card -->
            <div class="card">
                <div class="card-body">
                    <label for="title" class="form-label">Title <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}"
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
                              placeholder="Write a brief summary of your blog post...">{{ old('excerpt', $post->excerpt) }}</textarea>
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
                    <textarea id="editor" name="content">{{ old('content', $post->content) }}</textarea>
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
                            <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ old('status', $post->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>

                    @if($post->published_at)
                    <div class="info-badge">
                        <svg class="info-badge-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <div class="info-badge-content">
                            <div class="info-label">Published on</div>
                            <div class="info-value">{{ $post->published_at->format('F j, Y g:i A') }}</div>
                        </div>
                    </div>
                    @endif

                    <div class="flex justify-between space-x-2 mt-6">
                        <a href="{{ route('admin.blog.index') }}" class="btn-secondary flex-1 text-center">Cancel</a>
                        <button type="submit" class="btn-primary flex-1">Update Post</button>
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
                    @if($post->featured_image)
                    <div id="current-image" class="current-image">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Featured image" class="w-full h-auto">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <div class="flex space-x-2">
                                <button type="button" onclick="removeCurrentImage()" class="bg-white rounded-full p-2 shadow-md">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                <button type="button" onclick="document.getElementById('featured_image').click();" class="bg-white rounded-full p-2 shadow-md">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="remove_featured_image" id="remove_featured_image" value="0">
                    @else
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
                    @endif

                    <input id="featured_image" name="featured_image" type="file" accept="image/*" class="sr-only" onchange="previewImage(this);">

                    <div id="image-preview" class="image-preview hidden">
                        <img src="" alt="New preview" class="w-full h-auto">
                        <button type="button" onclick="removeNewImage()" class="absolute top-2 right-2 bg-white rounded-full p-1 shadow">
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
                        <input type="text" id="category" name="category" value="{{ old('category', $post->category) }}"
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
                        <input type="hidden" id="tags" name="tags" value="{{ old('tags', json_encode($post->tags ?? [])) }}">
                        <div id="tag-container" class="tag-container">
                            <!-- Tags will be added here dynamically -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Author Info Card -->
            <div class="card">
                <div class="card-header">
                    <svg class="section-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    <h2 class="text-lg font-medium">Author Information</h2>
                </div>
                <div class="card-body">
                    <div class="info-badge">
                        <svg class="info-badge-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <div class="info-badge-content">
                            <div class="info-label">Author</div>
                            <div class="info-value">{{ $post->user ? $post->user->name : 'Unknown' }}</div>
                        </div>
                    </div>

                    <div class="info-badge">
                        <svg class="info-badge-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="info-badge-content">
                            <div class="info-label">Created</div>
                            <div class="info-value">{{ $post->created_at->format('F j, Y g:i A') }}</div>
                        </div>
                    </div>

                    @if($post->updated_at && $post->updated_at->ne($post->created_at))
                    <div class="info-badge">
                        <svg class="info-badge-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <div class="info-badge-content">
                            <div class="info-label">Last Updated</div>
                            <div class="info-value">{{ $post->updated_at->format('F j, Y g:i A') }}</div>
                        </div>
                    </div>
                    @endif
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
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'link', '|',
                        'bulletedList', 'numberedList', '|',
                        'indent', 'outdent', '|',
                        'imageUpload', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                        'undo', 'redo'
                    ],
                    shouldNotGroupWhenFull: true
                },
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'imageStyle:inline',
                        'imageStyle:block',
                        'imageStyle:side'
                    ]
                },
                simpleUpload: {
                    // The URL that the images are uploaded to.
                    uploadUrl: '{{ route("admin.upload.image") }}',
                    // Headers sent along with the XMLHttpRequest to the upload server.
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                language: 'en',
                placeholder: 'Start writing your blog post here...'
            })
            .then(editor => {
                console.log('CKEditor initialized successfully');

                // Log success message when image is uploaded
                editor.plugins.get('FileRepository').on('uploaded', (evt, { data }) => {
                    console.log('Image uploaded successfully', data.url);
                });

                // Log error if upload fails
                editor.plugins.get('FileRepository').on('uploadFailed', (evt, { data }) => {
                    console.error('Image upload failed', data);
                    alert('Image upload failed. Please try again or use a smaller image.');
                });
            })
            .catch(error => {
                console.error('CKEditor initialization error:', error);
            });

        // Handle tags
        const tagsInput = document.getElementById('tags');
        const tagInput = document.getElementById('tag-input');
        const tagContainer = document.getElementById('tag-container');

        let tags = [];

        // Load any existing tags
        if (tagsInput.value) {
            tags = tagsInput.value.split(',').map(tag => tag.trim());
            renderTags();
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
                tagsInput.value = tags.join(',');
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
            tagsInput.value = tags.join(',');
            renderTags();
        };
    });

    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const img = preview.querySelector('img');
        const placeholder = document.getElementById('image-placeholder');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                img.src = e.target.result;
                preview.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage() {
        const preview = document.getElementById('image-preview');
        const input = document.getElementById('featured_image');
        const placeholder = document.getElementById('image-placeholder');

        preview.classList.add('hidden');
        input.value = '';
        if (placeholder) placeholder.classList.remove('hidden');
    }

    function removeCurrentImage() {
        const currentImage = document.getElementById('current-image');
        const removeInput = document.getElementById('remove_featured_image');

        currentImage.classList.add('hidden');
        removeInput.value = '1';

        // Show upload area
        const uploadArea = document.createElement('div');
        uploadArea.className = 'image-upload-area';
        uploadArea.setAttribute('onclick', "document.getElementById('featured_image').click();");
        uploadArea.innerHTML = `
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
        `;

        currentImage.parentNode.insertBefore(uploadArea, currentImage.nextSibling);
    }
</script>
@endpush
