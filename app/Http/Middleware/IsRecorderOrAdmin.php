<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsRecorderOrAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Allow if the user is admin (1) or recorder (3)
        if ($user && in_array($user->role_id, [1, 3])) {
            return $next($request);
        }

        // If not allowed, return forbidden
        return response()->json([
            'message' => 'Unauthorized – Only Admin or Recorder allowed'
        ], 403);
    }
}
