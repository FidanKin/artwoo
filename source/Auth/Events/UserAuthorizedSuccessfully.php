<?php

namespace Source\Auth\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Source\Event\AbstractEvent;
use Source\Helper\Enums\Crud;
use Source\Entity\User\Models\User;

/**
 * @method static dispatch(Crud $crud, int $userid, ?array $other, ?string $ip)
 */
class UserAuthorizedSuccessfully extends AbstractEvent
{
    use Dispatchable;

    public function __construct(
        Crud $crud,
        int $userId,
        array $other = null,
        string $ip = null
    ) {
        parent::__construct(crud: $crud, userId: $userId, objectTable: (new User)->getTable(),
            objectId: $userId, other: $other, ip: $ip);
    }
}
