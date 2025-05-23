@extends('admin.layouts.app')

@section('title', 'Model Details')

@section('page-heading', 'Model Information')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="grid grid-cols-1 gap-6">
        <div>
            <h3 class="text-sm font-medium text-gray-500">Model Name</h3>
            <p class="mt-1 text-base text-gray-900">{{ $model->name }}</p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500">Make</h3>
            <p class="mt-1 text-base text-gray-900">{{ $model->make->name }}</p>
        </div>

        @if($model->year)
        <div>
            <h3 class="text-sm font-medium text-gray-500">Year</h3>
            <p class="mt-1 text-base text-gray-900">{{ $model->year }}</p>
        </div>
        @endif

        @if($model->description)
        <div>
            <h3 class="text-sm font-medium text-gray-500">Description</h3>
            <p class="mt-1 text-base text-gray-900">{{ $model->description }}</p>
        </div>
        @endif

        <div>
            <h3 class="text-sm font-medium text-gray-500">Status</h3>
            <p class="mt-1 text-base text-gray-900">
                <span class="px-2 py-1 text-sm rounded-full {{ $model->isActive ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $model->isActive ? 'Active' : 'Inactive' }}
                </span>
            </p>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.models.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">Back to Models</a>
        <a href="{{ route('admin.models.edit', $model) }}" class="ml-2 px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">Edit Model</a>
    </div>
</div>
@endsection
