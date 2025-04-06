<?php

namespace Source\Tool\Loggers\Exceptions;



use Monolog\Handler\AbstractHandler;

class LoggerInvalidArgumentException extends \InvalidArgumentException
{
    public function __construct(AbstractHandler $handlerClass, string $operation, string $message = "", int $code = 0,
                                ?Throwable $previous = null)
    {
        $className = $handlerClass::class;
        $message = "Logger: $className; \n Invalid argument for $operation action; \n More: $message";
        parent::__construct($message, $code, $previous);
    }
}
