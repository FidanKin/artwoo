<?php

namespace Source\Event\Interfaces;

interface EventInterface
{
    /**
     * Get all event's data for saving in db
     *
     * @return array
     */
    public function getEventData(): array;
}
