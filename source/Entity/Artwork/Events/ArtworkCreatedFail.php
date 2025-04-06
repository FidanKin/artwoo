<?php

namespace Source\Entity\Artwork\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Source\Event\AbstractEvent;
use Source\Helper\Enums\Crud;

/**
 * @method static dispatch(Crud $crud, int $userid, array $other, ?string $ip)
 */
class ArtworkCreatedFail extends AbstractEvent
{
    use Dispatchable;

    public function __construct(Crud $crud, int $userid, array $other, ?string $ip)
    {
        parent::__construct(crud: $crud, userId: $userid, objectTable: 'artworks', other: $other, ip: $ip);
    }
}
