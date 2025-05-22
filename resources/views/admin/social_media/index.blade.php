@extends('admin.layouts.app')

@section('title', 'Social Media Links')

@section('page-heading', 'Social Media Management')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex flex-wrap justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">All Social Media Links</h2>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.social-media.create') }}" class="flex items-center gap-1 px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-all text-sm font-medium shadow">
                <i class="fas fa-plus"></i> Add Social Media
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 bg-gray-50 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Order</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Icon</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Platform</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody id="sortable-social-media" class="bg-white divide-y divide-gray-200">
                @forelse($socialMediaLinks as $link)
                <tr data-id="{{ $link->id }}">
                    <td class="px-4 py-4 whitespace-nowrap text-center">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-arrows-alt handle cursor-move text-gray-400 mr-2"></i>
                            <span class="order-display">{{ $link->display_order }}</span>
                            <input type="hidden" class="order-input" name="order[{{ $link->id }}]" value="{{ $link->display_order }}">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <i class="{{ $link->icon_class }} fa-lg text-gray-600"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $link->platform_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ $link->url }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline">
                            {{ Str::limit($link->url, 30) }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form action="{{ route('admin.social-media.toggle-active', $link->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $link->is_active ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $link->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-center">
                        <a href="{{ route('admin.social-media.show', ['social_medium' => $link->id]) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 mr-1" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.social-media.edit', ['social_medium' => $link->id]) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 hover:bg-yellow-200 mr-1" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.social-media.destroy', ['social_medium' => $link->id]) }}" method="POST" class="inline-block delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-200" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No social media links found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function() {
        // Initialize sortable for social media links
        $("#sortable-social-media").sortable({
            handle: '.handle',
            axis: 'y',
            update: function(event, ui) {
                // Update display order values
                $('#sortable-social-media tr').each(function(index) {
                    $(this).find('.order-display').text(index + 1);
                    $(this).find('.order-input').val(index + 1);
                });

                // Prepare data for AJAX
                var orders = {};
                $('.order-input').each(function() {
                    var id = $(this).closest('tr').data('id');
                    orders[id] = $(this).val();
                });

                // Send AJAX request to update order
                $.ajax({
                    url: "{{ route('admin.social-media.update-order') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        orders: orders
                    },
                    success: function(response) {
                        if (response.success) {
                            // Optional: show success message
                            console.log('Order updated successfully');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error updating order:', xhr.responseText);
                    }
                });
            }
        });

        // Confirm delete
        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this social media link?')) {
                this.submit();
            }
        });
    });
</script>
@endpush
