<?php

namespace Source\Event\Exceptions;

use InvalidArgumentException;

class EventInvalidArgumentException extends InvalidArgumentException
{
    /**
     * @param string $eventFullName - полное название события
     * @param string $message - дополнительное сообщение об ошибке
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $eventFullName, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $fullMessage = 'Invalid argument for Event - ' . $eventFullName . '; \n More: ' . $message;
        parent::__construct($fullMessage, $code, $previous);
    }
}
