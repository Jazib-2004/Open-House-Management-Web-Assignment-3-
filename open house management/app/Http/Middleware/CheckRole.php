<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CheckRole extends Middleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if ($user && in_array($user->role, $roles)) {
            return $next($request);
        }

        return redirect('login'); // Redirect to home or login page
    }
}
