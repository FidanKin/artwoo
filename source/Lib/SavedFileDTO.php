<?php

namespace Source\Lib;

use Symfony\Component\HttpFoundation\File\File;

class SavedFileDTO
{
    public function __construct(
      public readonly File $file,
      public readonly string $contentHash,
      public readonly int $order = 0
    ) {  }
}
