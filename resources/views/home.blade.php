@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-center">QR Code Generator</h1>
    
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
        <form id="qr-form" class="space-y-4">
            @csrf
            <div>
                <label for="url" class="block text-sm font-medium text-gray-700">Enter URL</label>
                <input type="url" name="url" id="url" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="dynamic" id="dynamic" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Convert this into a dynamic QR code</span>
                </label>
            </div>
            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Generate QR Code
                </button>
            </div>
        </form>
    </div>
    
    <div id="qr-result" class="mt-8 text-center hidden">
        <img id="qr-image" src="" alt="Generated QR Code" class="mx-auto">
        <button id="copy-qr" class="mt-4 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            Copy QR Code
        </button>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#qr-form').on('submit', function(e) {
            e.preventDefault();
            
            if ($('#dynamic').is(':checked')) {
                @guest
                    window.location.href = "{{ route('login') }}";
                @else
                    alert('Dynamic QR code generation is not yet implemented.');
                @endguest
                return;
            }
            
            $.ajax({
                url: '/generate-static-qr',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#qr-image').attr('src', response.qr_code);
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