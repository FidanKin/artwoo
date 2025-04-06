<?php

namespace Source\Auth\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Source\Event\AbstractEvent;
use Source\Helper\Enums\Crud;

/**
 * @method static dispatch(Crud $crud, array $other, ?string $ip)
 */
class UserCreateFailed extends AbstractEvent
{
    use Dispatchable;

    public function __construct(
        Crud $crud,
        array $other,
        string $ip = null
    ) {
        parent::__construct(crud: $crud, userId: 0, objectTable: 'users', other: $other, ip: $ip);
    }
}
