@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-center">Your QR Codes</h1>
    
    <div class="mb-4">
        <a href="{{ route('dynamic.create') }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Create New QR Code</a>
    </div>
    
    @if($dynamicQRCodes->isEmpty())
        <p class="text-center text-gray-600">You haven't created any QR codes yet.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($dynamicQRCodes as $qrCode)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-2">{{ $qrCode->description }}</h2>
                    <p class="text-gray-600 mb-2">Key: {{ $qrCode->key }}</p>
                    <p class="text-gray-600 mb-2">Redirect URL: {{ $qrCode->redirect_url }}</p>
                    <p class="text-gray-600 mb-2">
                        Active: 
                        @if($qrCode->active_from && $qrCode->active_to)
                            {{ $qrCode->active_from->format('Y-m-d H:i') }} to {{ $qrCode->active_to->format('Y-m-d H:i') }}
                        @elseif($qrCode->active_from)
                            From {{ $qrCode->active_from->format('Y-m-d H:i') }}
                        @elseif($qrCode->active_to)
                            Until {{ $qrCode->active_to->format('Y-m-d H:i') }}
                        @else
                            Always
                        @endif
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('dynamic.edit', $qrCode) }}" class="text-indigo-600 hover:text-indigo-800 mr-2">Edit</a>
                        <form action="{{ route('dynamic.destroy', $qrCode) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this QR code?')">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection