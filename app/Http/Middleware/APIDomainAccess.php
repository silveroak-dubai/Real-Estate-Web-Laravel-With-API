<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class APIDomainAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // List of allowed domains
        $allowedDomains = ['example.com', 'api.example.com'];

        // Get the request's host
        $origin = $request->headers->get('Origin') ?? $request->getHost();

        // Check if the request is coming from an allowed domain
        if (!in_array($origin, $allowedDomains)) {
            return response()->json(['error' => 'Unauthorized - Invalid Domain'], 403);
        }

        // Sanctum token authentication check
        if (!$request->user() || !$request->bearerToken()) {
            return response()->json(['error' => 'Unauthorized - Token Missing or Invalid'], 401);
        }

         return $next($request);
    }
}
