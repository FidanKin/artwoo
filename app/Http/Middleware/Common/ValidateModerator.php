<?php

namespace App\Http\Middleware\Common;

use Closure;
use Illuminate\Http\Request;
use Source\Lib\AppLib;
use Symfony\Component\HttpFoundation\Response;

class ValidateModerator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (AppLib::isModerator($request->user())) {
            return $next($request);
        }

        abort(Response::HTTP_FORBIDDEN);
    }
}
