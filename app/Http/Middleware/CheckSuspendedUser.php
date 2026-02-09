<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSuspendedUser
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_suspended) {

            $name = Auth::user()->name;

            Auth::logout();

            return redirect()->route('login')
                ->with('suspended', true)
                ->with('name', $name);
        }

        return $next($request);
    }
}
