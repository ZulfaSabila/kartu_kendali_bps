<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isAdmin()) {
            // Log unauthorized access attempt
            Log::warning('Unauthorized admin access attempt', [
                'user_id' => $request->user()?->id ?? 'Guest',
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
            ]);

            // Handle JSON requests
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Anda tidak memiliki akses'
                ], 403);
            }

            // Standard authorization failure
            abort(403, 'Anda tidak memiliki akses untuk melakukan tindakan ini.');
        }

        return $next($request);
    }
}
