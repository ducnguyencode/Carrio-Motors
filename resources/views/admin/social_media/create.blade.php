@extends('admin.layouts.app')

@section('title', 'Create Social Media Link')

@section('page-heading', 'Create Social Media Link')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
<style>
    .icon-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
        gap: 10px;
        max-height: 300px;
        overflow-y: auto;
        margin-top: 10px;
        padding: 10px;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
    }
    .icon-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 10px;
        cursor: pointer;
        border-radius: 0.25rem;
        transition: all 0.2s;
    }
    .icon-item:hover {
        background-color: #f3f4f6;
    }
    .icon-item.selected {
        background-color: #e5edff;
        border: 1px solid #3b82f6;
    }
    .icon-item i {
        font-size: 1.5rem;
        margin-bottom: 5px;
    }
    .icon-name {
        font-size: 0.6rem;
        text-align: center;
        color: #6b7280;
        word-break: break-all;
    }
    .search-container {
        position: relative;
        margin-bottom: 1rem;
    }
    .search-container input {
        padding-left: 2.5rem;
    }
    .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }
    /* Ensure modal is initially hidden but don't affect sidebar */
    #iconSelectorModal.hidden {
        display: none !important;
    }
</style>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="mb-6">
        <a href="{{ route('admin.social-media.index') }}" class="inline-flex items-center text-blue-600 hover:underline">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Social Media Links
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

    <form action="{{ route('admin.social-media.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="platform_name" class="block text-sm font-medium text-gray-700 mb-1">Platform Name <span class="text-red-500">*</span></label>
                <input type="text" id="platform_name" name="platform_name" value="{{ old('platform_name') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="e.g. Facebook, Twitter, Instagram" required>
            </div>

            <div>
                <label for="url" class="block text-sm font-medium text-gray-700 mb-1">URL <span class="text-red-500">*</span></label>
                <input type="url" id="url" name="url" value="{{ old('url') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="https://..." required>
            </div>

            <div>
                <label for="icon_class" class="block text-sm font-medium text-gray-700 mb-1">Choose Icon <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-12 gap-2 items-center">
                    <div class="col-span-1 flex justify-center">
                        <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded-md">
                            <i id="icon-preview" class="fab fa-facebook-f text-xl text-gray-700"></i>
                        </div>
                    </div>
                    <div class="col-span-9">
                        <input type="text" id="icon_class" name="icon_class" value="{{ old('icon_class', 'fab fa-facebook-f') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="fab fa-facebook-f" required readonly>
                    </div>
                    <div class="col-span-2">
                        <button type="button" id="openIconSelector" class="w-full inline-flex items-center justify-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Select Icon
                        </button>
                    </div>
                </div>

                <p class="mt-1 text-sm text-gray-500">
                    Font Awesome icon class will be automatically selected when you choose an icon.
                </p>
            </div>

            <div>
                <label for="display_order" class="block text-sm font-medium text-gray-700 mb-1">Display Order</label>
                <input type="number" id="display_order" name="display_order" value="{{ old('display_order', 0) }}" min="0"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <div class="mt-4">
            <div class="flex items-center">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="is_active" class="ml-2 block text-sm text-gray-700">Active</label>
            </div>
            <p class="mt-1 text-sm text-gray-500">Inactive links will not be displayed on the website.</p>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-5 border-t border-gray-200">
            <a href="{{ route('admin.social-media.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Create
            </button>
        </div>
    </form>
</div>

<!-- Icon Selector Modal -->
<div id="iconSelectorModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Select an Icon</h3>
            <button type="button" id="closeIconSelector" class="text-gray-400 hover:text-gray-500">
                <span class="sr-only">Close</span>
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="p-4">
            <div class="search-container">
                <span class="search-icon">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" id="iconSearch" placeholder="Search icons..." class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="icon-grid" id="iconGrid">
                <!-- Icons will be loaded here -->
            </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 flex justify-end">
            <button type="button" id="selectIconBtn" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Select
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        // Common social media icons
        const icons = [
            { name: 'facebook-f', prefix: 'fab' },
            { name: 'twitter', prefix: 'fab' },
            { name: 'instagram', prefix: 'fab' },
            { name: 'linkedin-in', prefix: 'fab' },
            { name: 'youtube', prefix: 'fab' },
            { name: 'pinterest', prefix: 'fab' },
            { name: 'tiktok', prefix: 'fab' },
            { name: 'snapchat', prefix: 'fab' },
            { name: 'whatsapp', prefix: 'fab' },
            { name: 'telegram', prefix: 'fab' },
            { name: 'discord', prefix: 'fab' },
            { name: 'reddit', prefix: 'fab' },
            { name: 'twitch', prefix: 'fab' },
            { name: 'github', prefix: 'fab' },
            { name: 'dribbble', prefix: 'fab' },
            { name: 'behance', prefix: 'fab' },
            { name: 'medium', prefix: 'fab' },
            { name: 'tumblr', prefix: 'fab' },
            { name: 'flickr', prefix: 'fab' },
            { name: 'vimeo-v', prefix: 'fab' },
            { name: 'soundcloud', prefix: 'fab' },
            { name: 'spotify', prefix: 'fab' },
            { name: 'apple', prefix: 'fab' },
            { name: 'android', prefix: 'fab' },
            { name: 'windows', prefix: 'fab' },
            { name: 'amazon', prefix: 'fab' },
            { name: 'google', prefix: 'fab' },
            { name: 'google-play', prefix: 'fab' },
            { name: 'app-store', prefix: 'fab' },
            { name: 'yahoo', prefix: 'fab' },
            { name: 'skype', prefix: 'fab' },
            { name: 'slack', prefix: 'fab' },
            { name: 'jira', prefix: 'fab' },
            { name: 'trello', prefix: 'fab' },
            { name: 'git', prefix: 'fab' },
            { name: 'gitlab', prefix: 'fab' },
            { name: 'bitbucket', prefix: 'fab' },
            { name: 'wordpress', prefix: 'fab' },
            { name: 'joomla', prefix: 'fab' },
            { name: 'drupal', prefix: 'fab' },
            { name: 'paypal', prefix: 'fab' },
            { name: 'stripe', prefix: 'fab' },
            { name: 'cc-visa', prefix: 'fab' },
            { name: 'cc-mastercard', prefix: 'fab' },
            { name: 'cc-amex', prefix: 'fab' },
            { name: 'cc-paypal', prefix: 'fab' },
            { name: 'bitcoin', prefix: 'fab' },
            { name: 'ethereum', prefix: 'fab' },
            { name: 'link', prefix: 'fas' },
            { name: 'globe', prefix: 'fas' },
            { name: 'share-alt', prefix: 'fas' },
            { name: 'rss', prefix: 'fas' }
        ];

        let selectedIcon = $('#icon_class').val();
        const iconGrid = $('#iconGrid');
        const modal = $('#iconSelectorModal');

        // Load icons into grid only when button is clicked
        function loadIcons(searchTerm = '') {
            iconGrid.empty();

            const filteredIcons = searchTerm ?
                icons.filter(icon => icon.name.includes(searchTerm.toLowerCase())) :
                icons;

            filteredIcons.forEach(icon => {
                const fullClass = `${icon.prefix} fa-${icon.name}`;
                const isSelected = fullClass === selectedIcon;

                const iconElement = $(`
                    <div class="icon-item ${isSelected ? 'selected' : ''}" data-icon="${fullClass}">
                        <i class="${fullClass}"></i>
                        <span class="icon-name">${icon.name}</span>
                    </div>
                `);

                iconGrid.append(iconElement);
            });

            // Attach click event to icons
            $('.icon-item').on('click', function() {
                $('.icon-item').removeClass('selected');
                $(this).addClass('selected');
                selectedIcon = $(this).data('icon');
            });
        }

        // Update icon preview when icon class changes
        $('#icon_class').on('input', function() {
            $('#icon-preview').attr('class', $(this).val() + ' text-xl text-gray-700');
        });

        // Open modal
        $('#openIconSelector').on('click', function(e) {
            e.preventDefault();
            loadIcons();
            modal.removeClass('hidden').css('display', 'flex');
        });

        // Close modal
        $('#closeIconSelector').on('click', function() {
            modal.addClass('hidden').css('display', 'none');
        });

        // Search icons
        $('#iconSearch').on('input', function() {
            loadIcons($(this).val());
        });

        // Select icon and close modal
        $('#selectIconBtn').on('click', function() {
            if (selectedIcon) {
                $('#icon_class').val(selectedIcon);
                $('#icon-preview').attr('class', selectedIcon + ' text-xl text-gray-700');
                modal.addClass('hidden').css('display', 'none');
            }
        });

        // Close modal when clicking outside
        $(window).on('click', function(e) {
            if ($(e.target).is(modal)) {
                modal.addClass('hidden').css('display', 'none');
            }
        });

        // Ensure modal is initially hidden
        modal.addClass('hidden').css('display', 'none');
    });
</script>
@endpush
