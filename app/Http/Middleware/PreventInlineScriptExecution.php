<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventInlineScriptExecution
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('Content-Security-Policy', "default-src * 'self'; worker-src 'self' blob:; style-src * 'unsafe-inline' 'self' data:; font-src * 'self' data:; img-src * 'self' data:; script-src * 'unsafe-inline' 'self' 'unsafe-eval'; frame-ancestors 'self'; form-action 'self' http://localhost:8000 http://127.0.0.1:8000 http://127.0.0.1:5173 https://cdnjs.cloudflare.com https://fonts.googleapis.com https://www.flaticon.com http://www.w3.org");

        return $response;
    }
}
