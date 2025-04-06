<?php

namespace Source\Lib;

class FileIdentityDTO
{
    public function __construct(
        public readonly string $component,
        public readonly int $userid,
        public readonly int $itemid,
        public readonly string $filearea = 'store',
        public readonly string $status = 'unverified',
        public readonly string $filename = '',
    ) { }
}
