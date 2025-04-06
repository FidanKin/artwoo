<?php

namespace Source\Entity\Artwork\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Source\Event\AbstractEvent;
use Source\Helper\Enums\Crud;

/**
 * @method static dispatch(Crud $crud, int $artworkId, int $userid, ?array $other, string $ip)
 */
class ArtworkCreatedSuccessfully extends AbstractEvent
{
    use Dispatchable;

    public function __construct(Crud $crud, int $artworkId, int $userid, ?array $other, ?string $ip)
    {
        parent::__construct(crud: $crud, userId: $userid, objectTable: 'artworks', objectId: $artworkId, other: $other, ip: $ip);
    }
}
