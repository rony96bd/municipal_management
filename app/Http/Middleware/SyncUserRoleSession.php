<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SyncUserRoleSession
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user) {
            return $next($request);
        }

        $currentRole = $user->role ?? 'admin';
        if (!$request->session()->has('auth_user_role')) {
            $request->session()->put('auth_user_role', $currentRole);
            return $next($request);
        }

        if ($request->session()->get('auth_user_role') !== $currentRole) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login');
        }

        return $next($request);
    }
}
