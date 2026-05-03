<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings');
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