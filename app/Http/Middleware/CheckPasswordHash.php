<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CheckPasswordHash
{
    public function handle($request, Closure $next)
    {
        Log::info('Middleware CheckPasswordHash dipanggil.');
        
        $user = Auth::user();

        if ($user && Hash::needsRehash($user->password)) {
            $user->password = Hash::make($request->input('current_password'));
            $user->save();
        }

        return $next($request);
    }
}

