<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PushNotificationController extends Controller
{
    public function store(Request $request)
    {
        // 1. Ubah validasi menggunakan $request->validate()
        $request->validate([
            'endpoint'    => 'required',
            'keys.auth'   => 'required',
            'keys.p256dh' => 'required',
        ]);

        $endpoint = $request->input('endpoint');
        $token = $request->input('keys.auth');
        $key = $request->input('keys.p256dh');
        $encoding = $request->input('content_encoding');

        // 2. Gunakan Auth::user() untuk menghindari error pada helper auth()
        $user = Auth::user();

        if ($user) {
            $user->updatePushSubscription($endpoint, $key, $token, $encoding);
            return response()->json(['success' => true, 'message' => 'Berhasil berlangganan notifikasi!']);
        }

        return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu.'], 401);
    }
}
