<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasFilledProfile
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Ganti ini sesuai field yang menunjukkan bahwa data diri sudah diisi
        if (!$user->profile_completed) {
            return redirect()->route('data-diri.form');
        }

        return $next($request);
    }
}
