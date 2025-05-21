<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Check if authenticated and role_id is 1 (admin)
        if ($user && $user->role_id === 1) {
            return $next($request);
        }

        // If not admin, deny access
        return response()->json([
            'message' => 'Unauthorized – Admin access only'
        ], 403);
    }
}
