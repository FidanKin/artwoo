<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Source\Tool\Loggers\Exceptions\LoggerInvalidArgumentException;

class WriteLogDB
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(\Source\Event\AbstractEvent $event): void
    {
        try {
            Log::channel('db')->info('db write log', $event->getEventData());
        } catch (LoggerInvalidArgumentException $exception) {
            Log::debug($exception->getMessage());
        }

    }

}
