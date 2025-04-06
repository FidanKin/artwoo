<?php

namespace Source\Event;

class EventDTO
{
    public function __construct(
        public string $eventName,
        public string $component,
        public string $action,
        public string $crud,
        public int $userId,
        public string $createdAt,
        public ?string $objectTable = null,
        public ?int $objectId = null,
        public ?int $relatedUserId = null,
        public ?string $other = null,
        public ?string $ip = null
    ) {

    }
}
