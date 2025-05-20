@extends('admin.layouts.app')

@section('title', 'Car Colors')

@section('page-heading', 'Car Color Management')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex flex-wrap justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">All Car Colors</h2>
        <a href="{{ route('admin.car_colors.create') }}" class="flex items-center gap-1 px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-all text-sm font-medium shadow">
            <i class="fas fa-plus"></i> Add Car Color
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-center text-xs font-semibold text-gray-500 uppercase">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Color Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Color Preview</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($carcolors as $index => $color)
                    <tr>
                        <td class="px-4 py-2 text-center">{{ ($carcolors->currentPage() - 1) * $carcolors->perPage() + $index + 1 }}</td>
                        <td class="px-6 py-4">{{ $color->name }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full mr-2 border border-gray-200" style="background-color: {{ $color->hex_code }}"></div>
                                <span class="text-sm font-medium">{{ $color->hex_code }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($color->is_active)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.car_colors.edit', $color) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.car_colors.destroy', $color) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this color?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No car colors found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $carcolors->links() }}
    </div>
</div>
@endsection
