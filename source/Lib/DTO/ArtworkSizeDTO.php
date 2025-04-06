<?php

namespace Source\Lib\DTO;

class ArtworkSizeDTO
{
    public function __construct(
        public readonly float $width,
        public readonly float $height,
        public readonly float|null $depth,
    ) {

    }
}