<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     * Handle Api Key which set in request query param
     *
     * @param Request $request
     * @param Closure $next
     * @return Response $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->query('api_key') === config('app.api_key')) {
            return $next($request);
        }

        abort(403, 'Not allowed');
    }
}
