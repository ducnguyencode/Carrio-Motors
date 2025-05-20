@extends('admin.layouts.app')

@section('title', 'Make Details')

@section('page-heading', 'Make Information')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="grid grid-cols-1 gap-6">
        <div>
            <h3 class="text-sm font-medium text-gray-500">Make Name</h3>
            <p class="mt-1 text-base text-gray-900">{{ $make->name }}</p>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('makes.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">Back to Makes</a>
    </div>
</div>
@endsection