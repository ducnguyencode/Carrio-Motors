@extends('admin.layouts.app')

@section('title', 'Car Details')

@section('page-heading', 'Car Detail Management')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex flex-wrap justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">All Car Details</h2>
        <div class="flex items-center gap-2">
            <form action="{{ route('admin.car_details.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search car details..." class="border border-gray-300 rounded-full px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm">
                <select name="status" class="border border-gray-300 rounded-full px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                <button type="submit" class="flex items-center gap-1 px-4 py-2 rounded-full border border-blue-500 text-blue-500 bg-white hover:bg-blue-50 transition-all text-sm font-medium">
                    <i class="fas fa-search"></i> Search
                </button>
                @if(request('search') || request('status'))
                <a href="{{ route('admin.car_details.index') }}" class="flex items-center gap-1 px-4 py-2 rounded-full border border-gray-500 text-gray-500 bg-white hover:bg-gray-50 transition-all text-sm font-medium">
                    <i class="fas fa-times"></i> Reset
                </a>
                @endif
            </form>
            <a href="{{ route('admin.car_details.create') }}" class="flex items-center gap-1 px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-all text-sm font-medium shadow">
                <i class="fas fa-plus"></i> Add Car Detail
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 bg-gray-50 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Car</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Color</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($carDetails as $index => $detail)
                    <tr>
                        <td class="px-4 py-2 text-center">{{ ($carDetails->currentPage() - 1) * $carDetails->perPage() + $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $detail->car->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="h-4 w-4 inline-block rounded-full mr-2" style="background-color: {{ $detail->carColor->hex_code ?? '#ccc' }}"></span>
                                {{ $detail->carColor->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $detail->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($detail->price, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($detail->is_available)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.car_details.show', $detail) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 mr-1" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.car_details.edit', $detail) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 hover:bg-yellow-200 mr-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.car_details.destroy', $detail) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this car detail?')">
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
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No car details found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $carDetails->withQueryString()->links() }}
    </div>
</div>
@endsection
