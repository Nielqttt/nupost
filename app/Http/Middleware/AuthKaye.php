<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\KayeToken;

class AuthKaye
{
    public function handle(Request $request, Closure $next)
    {
        if (session('role') !== 'kaye' || !session('kaye_token')) {
            return redirect()->route('kaye.login.expired', ['reason' => 'missing']);
        }

        $tokenStr = session('kaye_token');
        $token = KayeToken::where('token', $tokenStr)->first();

        if (!$token || !$token->isValid()) {
            session()->forget(['role', 'kaye_token', 'expires_at']);
            return redirect()->route('kaye.login.expired', ['reason' => 'expired']);
        }

        return $next($request);
    }
}
