@extends('admin.layouts.app')

@section('title', 'Blog Management')

@section('page-heading', 'Blog Management')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex flex-wrap justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">All Blog Posts</h2>
        <div class="flex items-center gap-2">
            <form action="{{ route('admin.blog.index') }}" method="GET" class="flex items-center gap-2">
                <select name="status" class="border border-gray-300 rounded-full px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm">
                    <option value="">All Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts..." class="border border-gray-300 rounded-full px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm">
                <button type="submit" class="flex items-center gap-1 px-4 py-2 rounded-full border border-blue-500 text-blue-500 bg-white hover:bg-blue-50 transition-all text-sm font-medium">
                    <i class="fas fa-search"></i> Search
                </button>
                @if(request('search') || request('status'))
                <a href="{{ route('admin.blog.index') }}" class="flex items-center gap-1 px-4 py-2 rounded-full border border-gray-500 text-gray-500 bg-white hover:bg-gray-50 transition-all text-sm font-medium">
                    <i class="fas fa-times"></i> Reset
                </a>
                @endif
            </form>
            <a href="{{ route('admin.blog.create') }}" class="flex items-center gap-1 px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-all text-sm font-medium shadow">
                <i class="fas fa-plus"></i> Add Blog Post
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 border-l-4 border-green-500 text-green-700 rounded flex justify-between items-center">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.style.display='none'" class="ml-4 text-green-700 hover:text-green-900">&times;</button>
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 bg-gray-50 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-10">#</th>
                    <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Category</th>
                    <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Status</th>
                    <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Author</th>
                    <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-28">Published</th>
                    <th class="px-4 py-2 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-28">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($posts as $index => $post)
                <tr>
                    <td class="px-4 py-2 text-center">{{ ($posts->currentPage() - 1) * $posts->perPage() + $index + 1 }}</td>
                    <td class="px-4 py-3">
                        <div class="text-sm font-medium text-gray-900 truncate max-w-xs" title="{{ $post->title }}">
                            {{ Str::limit($post->title, 30) }}
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        @if($post->category)
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">{{ $post->category }}</span>
                        @else
                        <span class="text-gray-500 text-sm">No category</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if($post->status == 'published')
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Published</span>
                        @elseif($post->status == 'draft')
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Draft</span>
                        @else
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Archived</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="text-sm font-medium text-gray-900">{{ $post->author->fullname ?? $post->author->username }}</div>
                        <div class="text-xs text-gray-500">{{ $post->author->email ?? 'No email' }}</div>
                    </td>
                    <td class="px-4 py-3">
                        @if($post->published_at)
                        <span class="text-sm">{{ $post->published_at->format('M d, Y') }}</span>
                        @else
                        <span class="text-gray-500 text-sm">Not published</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center space-x-1">
                            <a href="{{ route('blog.post', $post->slug) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200" title="View" target="_blank">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.blog.edit', $post->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 hover:bg-yellow-200" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($post->status != 'published')
                            <form action="{{ route('admin.blog.status', $post->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="published">
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-600 hover:bg-green-200" title="Publish">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-200" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-3 text-center text-gray-500">No blog posts found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endpush
