<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index()
    {
        $kayeToken = \App\Models\KayeToken::orderByDesc('id')->first();
        return view('admin.settings', compact('kayeToken'));
    }

    public function generateKayeToken()
    {
        \App\Models\KayeToken::query()->delete();

        $tokenStr = bin2hex(random_bytes(32));
        $expiresAt = now()->addDays(60);

        \App\Models\KayeToken::create([
            'token' => $tokenStr,
            'expires_at' => $expiresAt,
        ]);

        return back()->with('success', 'New access token generated successfully for Ms. Kaye.');
    }

    public function revokeKayeToken()
    {
        \App\Models\KayeToken::query()->delete();
        return back()->with('success', 'Access token revoked successfully.');
    }

    public function updateProfile(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $email = session('admin_email');
        if ($email) {
            $user = \App\Models\User::where('email', $email)->first();
            if ($user) {
                $user->name = $request->name;
                $user->save();
                session(['admin_name' => $user->name]);
            }
        }

        return back()->with('success', 'Profile updated successfully.');
    }
}