<?php

namespace Source\Entity\Chat\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Source\Event\AbstractEvent;
use Source\Helper\Enums\Crud;

/**
 * @method static dispatch(Crud $crud, int $chatId, int $userid, array $other, ?string $ip)
 */
class ChatCreated extends AbstractEvent
{
    use Dispatchable;
    public function __construct(Crud $crud, int $chatId, int $userid, array $other, ?string $ip)
    {
        parent::__construct(crud: $crud, userId: $userid, objectTable: 'chats', objectId: $chatId, other: $other, ip: $ip);
    }
}
