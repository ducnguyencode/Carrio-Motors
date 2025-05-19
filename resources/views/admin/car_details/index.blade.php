@extends('admin.layouts.app')

@section('title', 'Car Details')

@section('page-heading', 'Car Detail Management')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex flex-wrap justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">All Car Details</h2>
        <a href="{{ route('admin.car_details.create') }}" class="flex items-center gap-1 px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-all text-sm font-medium shadow">
            <i class="fas fa-plus"></i> Add Car Detail
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-center text-xs font-semibold text-gray-500 uppercase">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Car</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Color</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($carDetails as $index => $detail)
                    <tr>
                        <td class="px-4 py-2 text-center">{{ ($carDetails->currentPage() - 1) * $carDetails->perPage() + $index + 1 }}</td>
                        <td class="px-6 py-4">{{ $detail->car->name }}</td>
                        <td class="px-6 py-4">{{ $detail->carColor->color_name }}</td>
                        <td class="px-6 py-4">{{ $detail->quantity }}</td>
                        <td class="px-6 py-4">${{ number_format($detail->price, 2) }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.car_details.edit', $detail) }}" class="text-yellow-600 hover:text-yellow-800">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.car_details.destroy', $detail) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No car details found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $carDetails->links() }}
    </div>
</div>
@endsection