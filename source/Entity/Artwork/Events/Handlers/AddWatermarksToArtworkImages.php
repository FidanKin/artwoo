<?php

namespace Source\Entity\Artwork\Events\Handlers;

use Source\Entity\Artwork\Events\ArtworkCreatedSuccessfully;
use Source\Entity\User\Models\User;
use Source\Lib\FileIdentityDTO;
use Source\Lib\FileStorage;
use function Source\Lib\artwooAddImageWatermark;

class AddWatermarksToArtworkImages
{
    public function handle(ArtworkCreatedSuccessfully $event): void
    {
        $fs = new FileStorage();
        $eventData = $event->getEventData();
        $files = $fs->getFiles(new FileIdentityDTO('artwork', $eventData['user_id'], $eventData['object_id']));
        $user = User::find($eventData['user_id']);

        if (empty($files) || empty($user)) {
            return;
        }

        foreach ($files as $file) {
            artwooAddImageWatermark($file, $user);
        }
    }
}