<?php

namespace Source\Event;

use Illuminate\Foundation\Events\Dispatchable;
use Source\Event\AbstractEvent;
use Source\Helper\Enums\Crud;

class FileNotDeleted extends AbstractEvent
{
    use Dispatchable;

    public function __construct(Crud $crud, int $objectId = null, ?array $other = null)
    {
        parent::__construct($crud, 'core_file', 1, 'files', $objectId, null, $other, '127.0.0.1');
    }
}
