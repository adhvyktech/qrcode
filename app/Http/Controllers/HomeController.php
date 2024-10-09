<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function generateStaticQR(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $url = $request->input('url');
        $qrCode = QrCode::size(300)->generate($url);

        return response()->json(['qr_code' => base64_encode($qrCode->toDataUri())]);
    }
}