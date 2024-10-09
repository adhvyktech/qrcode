@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-center">Create Dynamic QR Code</h1>
    
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
        <form id="dynamic-qr-form" class="space-y-4">
            @csrf
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <input type="text" name="description" id="description" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div>
                <label for="redirect_url" class="block text-sm font-medium text-gray-700">Redirect URL</label>
                <input type="url" name="redirect_url" id="redirect_url" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div>
                <label for="active_from" class="block text-sm font-medium text-gray-700">Active From</label>
                <input type="datetime-local" name="active_from" id="active_from" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div>
                <label for="active_to" class="block text-sm font-medium text-gray-700">Active To</label>
                <input type="datetime-local" name="active_to" id="active_to" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Generate Dynamic QR Code
                </button>
            </div>
        </form>
    </div>
    
    <div id="qr-result" class="mt-8 text-center hidden">
        <img id="qr-image" src="" alt="Generated QR Code" class="mx-auto">
        <p id="qr-key" class="mt-4 text-lg font-semibold"></p>
        <button id="copy-qr" class="mt-4 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600  hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            Copy QR Code
        </button>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dynamic-qr-form').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: '{{ route("dynamic.store") }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#qr-image').attr('src', response.qr_code);
                    $('#qr-key').text('Key: ' + response.key);
                    $('#qr-result').removeClass('hidden');
                },
                error: function() {
                    alert('An error occurred while generating the QR code.');
                }
            });
        });

        $('#copy-qr').on('click', function() {
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            var img = document.getElementById('qr-image');
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0, img.width, img.height);
            canvas.toBlob(function(blob) {
                navigator.clipboard.write([
                    new ClipboardItem({ 'image/png': blob })
                ]).then(function() {
                    alert('QR code copied to clipboard!');
                }, function() {
                    alert('Failed to copy QR code.');
                });
            });
        });
    });
</script>
@endsection