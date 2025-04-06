<?php

namespace Source\Lib\Api;

class ApiControllerException extends \RuntimeException implements \JsonSerializable
{
    public function __construct(private readonly string $path, private readonly array $params,
        string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Получить главную строку запроса (это компонент, реализущий обработчик запроса)
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Получить параметры запроса
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * задаем данные, будут передаваться в json_encode
     */
    public function jsonSerialize(): array
    {
        return $this->getInfo();
    }

    public function getInfo(): array
    {
        return [
            'path' => $this->getPath(),
            'params' => $this->getParams(),
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
        ];
    }
}
