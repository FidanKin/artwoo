<?php

namespace App\Listeners;

use Source\Entity\Artwork\Dictionaries\ArtworkStatus;
use Source\Event\ItemModerated;
use Source\Entity\Artwork\Models\Artwork;

class UpdateArtworkStatus
{
    public function handle(ItemModerated $event): void
    {
        if ($event->moderation->component === 'artwork') {
            $artwork = Artwork::find($event->moderation->object_id);

            if ($artwork) {
                if (! in_array($event->getStatus(), array_keys(ArtworkStatus::select()))) {
                    return;
                }
                $artwork->status = $event->getStatus();
                $artwork->save();
            }
        }
    }
}
