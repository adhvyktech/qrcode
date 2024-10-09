@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-center">Edit Dynamic QR Code</h1>
    
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('dynamic.update', $dynamicQRCode) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <input type="text" name="description" id="description" value="{{ $dynamicQRCode->description }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div>
                <label for="redirect_url" class="block text-sm font-medium text-gray-700">Redirect URL</label>
                <input type="url" name="redirect_url" id="redirect_url" value="{{ $dynamicQRCode->redirect_url }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div>
                <label for="active_from" class="block text-sm font-medium text-gray-700">Active From</label>
                <input type="datetime-local" name="active_from" id="active_from" value="{{ $dynamicQRCode->active_from ? $dynamicQRCode->active_from->format('Y-m-d\TH:i') : '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div>
                <label for="active_to" class="block text-sm font-medium text-gray-700">Active To</label>
                <input type="datetime-local" name="active_to" id="active_to" value="{{ $dynamicQRCode->active_to ? $dynamicQRCode->active_to->format('Y-m-d\TH:i') : '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update QR Code
                </button>
            </div>
        </form>
    </div>
</div>
@endsection