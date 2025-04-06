<?php

namespace App\Http\Middleware\Common;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Source\Entity\Chat\Models\ChatUser;

class UserInChat
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! ChatUser::isUserInChat($request->user()->id, $request->route("id"))) {
            abort(403);
        }

        return $next($request);
    }
}
