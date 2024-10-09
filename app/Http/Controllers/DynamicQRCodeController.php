<?php

namespace App\Http\Controllers;

use App\Models\DynamicQRCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DynamicQRCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('dynamic_qr_codes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'redirect_url' => 'required|url',
            'active_from' => 'nullable|date',
            'active_to' => 'nullable|date|after:active_from',
        ]);

        $dynamicQRCode = DynamicQRCode::create([
            'user_id' => auth()->id(),
            'description' => $request->description,
            'key' => Str::random(8),
            'redirect_url' => $request->redirect_url,
            'active_from' => $request->active_from,
            'active_to' => $request->active_to,
        ]);

        $qrCode = QrCode::size(300)->generate(route('dynamic.redirect', $dynamicQRCode->key));

        return response()->json([
            'qr_code' => base64_encode($qrCode->toDataUri()),
            'key' => $dynamicQRCode->key,
        ]);
    }

    public function edit(DynamicQRCode $dynamicQRCode)
    {
        return view('dynamic_qr_codes.edit', compact('dynamicQRCode'));
    }

    public function update(Request $request, DynamicQRCode $dynamicQRCode)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'redirect_url' => 'required|url',
            'active_from' => 'nullable|date',
            'active_to' => 'nullable|date|after:active_from',
        ]);

        $dynamicQRCode->update([
            'description' => $request->description,
            'redirect_url' => $request->redirect_url,
            'active_from' => $request->active_from,
            'active_to' => $request->active_to,
        ]);

        return redirect()->route('dashboard')->with('success', 'QR code updated successfully.');
    }

    public function destroy(DynamicQRCode $dynamicQRCode)
    {
        $dynamicQRCode->delete();
        return redirect()->route('dashboard')->with('success', 'QR code deleted successfully.');
    }

    public function redirect($key)
    {
        $dynamicQRCode = DynamicQRCode::where('key', $key)->firstOrFail();

        if ($dynamicQRCode->active_from && $dynamicQRCode->active_from->isFuture()) {
            abort(404);
        }

        if ($dynamicQRCode->active_to && $dynamicQRCode->active_to->isPast()) {
            abort(404);
        }

        return redirect($dynamicQRCode->redirect_url);
    }
}