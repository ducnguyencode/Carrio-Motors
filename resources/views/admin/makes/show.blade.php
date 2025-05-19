@extends('admin.layouts.app')

@section('title', 'Make Details')

@section('page-heading', 'Make Details')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl mx-auto">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Make Name:</label>
        <p class="px-4 py-3 bg-gray-100 rounded-lg">{{ $make->name }}</p>
    </div>

    <div class="flex justify-end gap-2 mt-8">
        <a href="{{ route('admin.makes.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">Back</a>
        <a href="{{ route('admin.makes.edit', $make) }}" class="px-6 py-2 rounded-lg bg-yellow-600 text-white hover:bg-yellow-700 font-semibold shadow transition">Edit Make</a>
    </div>
</div>
@endsection