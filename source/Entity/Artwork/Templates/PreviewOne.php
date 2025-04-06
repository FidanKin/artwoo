<?php

namespace Source\Entity\Artwork\Templates;

use Source\Entity\Artwork\Models\Artwork;

readonly class PreviewOne
{
    public function __construct(private Artwork $artwork, private array $artworkImagesUrl)
    {

    }

    /**
     * @return array{id: int, image_url: string}
     */
    public function getContext(): array
    {
        return ['id' => $this->artwork->id, 'image_url' => $this->artworkImagesUrl[0]];
    }
}
