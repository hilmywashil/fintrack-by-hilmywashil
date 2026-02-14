<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsurePasswordResetFlow
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('reset_email')) {
            return redirect()->route('forgot.password')
                ->with('error', 'Silakan isi email untuk melanjutkan proses reset password.');
        }

        return $next($request);
    }

}
