<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;

        if (!in_array($userRole, $roles)) {
            if ($userRole === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('kasir.dashboard');
            }
        }

        return $next($request);
    }
}