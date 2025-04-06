<?php

namespace Source\Auth\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Source\Event\AbstractEvent;
use Source\Helper\Enums\Crud;

/**
 * Событие неудачной авторизации
 *
 * @method static dispatch(Crud $crud, ?array $other, ?string $ip)
 *
 */
class UserAuthorizedFailed extends AbstractEvent
{
    use Dispatchable;

    /**
     * @param Crud $crud
     * @param array|null $other
     * @param string|null $ip
     */
    public function __construct(
        Crud $crud,
        array $other = null,
        string $ip = null
    ) {
        parent::__construct(crud: $crud, userId: 0, other: $other, ip: $ip);
    }
}
