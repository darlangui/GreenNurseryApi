<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->role !== 'ADMIN') {
            return response()->json(
                [
                    'message' => 'Unauthorized',
                    'description' => "The user doesn't have permission to access this route"
                ],
                401
            );
        }
        return $next($request);
    }
}
