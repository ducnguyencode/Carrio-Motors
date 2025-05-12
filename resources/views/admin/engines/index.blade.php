@extends('admin.layouts.app')

@section('title', 'Engines')

@section('page-heading', 'Engines')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">All Engines</h2>
        <a href="{{ route('admin.engines.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            <i class="fas fa-plus mr-2"></i> Add New Engine
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Displacement</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cylinders</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Power</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fuel Type</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($engines as $engine)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $engine->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $engine->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $engine->displacement ? $engine->displacement . 'L' : 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $engine->cylinders ?: 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $engine->power ? $engine->power . ' HP' : 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $engine->fuel_type == 'gasoline' ? 'bg-blue-100 text-blue-800' :
                                   ($engine->fuel_type == 'diesel' ? 'bg-gray-100 text-gray-800' :
                                   ($engine->fuel_type == 'electric' ? 'bg-green-100 text-green-800' :
                                   ($engine->fuel_type == 'hybrid' ? 'bg-purple-100 text-purple-800' : 'bg-indigo-100 text-indigo-800'))) }}">
                                {{ ucfirst($engine->fuel_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.engines.show', $engine) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.engines.edit', $engine) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.engines.destroy', $engine) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this engine?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No engines found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $engines->links() }}
    </div>
</div>
@endsection
