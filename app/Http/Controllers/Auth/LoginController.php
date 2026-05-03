<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LoginAttempt;
use App\Models\RememberedDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $success = session()->pull('reg_success', null);
        return view('auth.login', compact('success'));
    }

    public function store(Request $request)
    {
        // CSRF is handled by Laravel automatically

        $email    = trim($request->input('email', ''));
        $password = trim($request->input('password', ''));



        // Rate limit check
        if (LoginAttempt::isRateLimited($email)) {
            return back()->withInput()->with('error', 'Too many failed attempts. Please wait 15 minutes.');
        }

        // Database login check
        $user = User::where('email', $email)->first();

        if ($user && (Hash::check($password, $user->password) || $user->password === $password)) {
            // Check role
            if ($user->role === 'admin') {
                LoginAttempt::create(['email' => $email, 'ip_address' => $request->ip(), 'success' => true, 'attempted_at' => now()]);
                session()->regenerate();
                session([
                    'role'        => 'admin',
                    'admin_email' => $user->email,
                    'admin_name'  => $user->name,
                ]);
                return redirect()->route('admin.dashboard');
            }

            // For requestors, require email verification
            if (!$user->is_verified) {
                LoginAttempt::create(['email' => $email, 'ip_address' => $request->ip(), 'success' => false, 'attempted_at' => now()]);

                // Check if a valid OTP already exists
                $existingOtp = \App\Models\OtpCode::where('user_id', $user->id)
                    ->where('is_used', false)
                    ->where('expires_at', '>', now())
                    ->first();

                if (!$existingOtp) {
                    $otp        = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                    $expires_at = now()->addMinutes(10);

                    \App\Models\OtpCode::create([
                        'user_id'    => $user->id,
                        'email'      => $user->email,
                        'otp_code'   => $otp,
                        'expires_at' => $expires_at,
                    ]);

                    try {
                        \Illuminate\Support\Facades\Mail::send([], [], function ($message) use ($user, $otp) {
                            $message->to($user->email, $user->name)
                                ->subject('Your NUPost Verification Link')
                                ->html(\App\Http\Controllers\Auth\OtpController::getOtpEmailHtml($user->name, $otp, $user->email));
                        });
                    } catch (\Exception $e) {
                        \Log::error('[NUPost] Login auto-resend OTP failed: ' . $e->getMessage());
                    }

                    return back()->withInput()->with('error', 'Please verify your email first. A new verification link has been sent to your inbox.');
                }

                return back()->withInput()->with('error', 'Please verify your email first. Check your inbox for the verification link.');
            }

            LoginAttempt::create(['email' => $email, 'ip_address' => $request->ip(), 'success' => true, 'attempted_at' => now()]);
            session()->regenerate();
            session([
                'role'    => 'requestor',
                'user_id' => $user->id,
                'name'    => $user->name,
            ]);

            // Remember Me
            if ($request->has('remember_me')) {
                $token      = bin2hex(random_bytes(32));
                $expires_at = now()->addDays(7);
                RememberedDevice::where('user_id', $user->id)->delete();
                RememberedDevice::create(['user_id' => $user->id, 'token' => $token, 'expires_at' => $expires_at]);
                cookie()->queue('remember_token', $token, 60 * 24 * 7, '/', null, false, true);
            }

            return redirect()->route('requestor.dashboard');
        }

        LoginAttempt::create(['email' => $email, 'ip_address' => $request->ip(), 'success' => false, 'attempted_at' => now()]);
        $remaining = max(0, 5 - LoginAttempt::countRecent($email));
        return back()->withInput()->with('error', "Invalid email or password. {$remaining} attempt(s) remaining.");
    }

    public function destroy(Request $request)
    {
        if ($request->cookie('remember_token')) {
            RememberedDevice::where('token', $request->cookie('remember_token'))->delete();
            cookie()->queue(cookie()->forget('remember_token'));
        }
        session()->flush();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}