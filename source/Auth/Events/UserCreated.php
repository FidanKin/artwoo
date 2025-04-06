<?php

namespace Source\Auth\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Source\Event\AbstractEvent;
use Source\Helper\Enums\Crud;

/**
 * @method static dispatch(Crud $crud, int $userid, ?array $other, ?string $ip)
 */
class UserCreated extends AbstractEvent
{
    use Dispatchable;

    public function __construct(
        Crud $crud,
        int $userId,
        array $other = null,
        string $ip = null
    ) {
        parent::__construct(crud: $crud, userId: $userId, objectTable: 'users',
            objectId: $userId, other: $other, ip: $ip);
    }
}
