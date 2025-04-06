<?php

namespace App\Http\Middleware;

use App\Http\Middleware\Common\UserInChat;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\Api\VerifyApiKey;
use App\Http\Middleware\Common\ValidateModerator;

class Handler
{
    protected array $aliases = [
        'apikey' => VerifyApiKey::class,
        'moderator' => ValidateModerator::class,
        'user.in_chat' => UserInChat::class
//        \App\Http\Middleware\EncryptCookies::class,


    ];

    public function __invoke(Middleware $middleware): Middleware
    {
        if ($this->aliases) {
            $middleware->alias($this->aliases);
        }

        return $middleware;
    }
}
