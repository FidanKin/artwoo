<?php

namespace Source\Lib\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#client_error_responses - http коды

abstract class ApiController
{
    public function __construct(
        protected readonly Request $request
    ) {
        $this->baseValidateRequest();
    }

    final protected function baseValidateRequest(): void
    {

    }

    /**
     * Проверяет, есть ли запросе указанный параметр. Если есть, то возвращает его,
     * если нет, то выбрасывает исключение
     *
     *
     * @return array|\Illuminate\Http\JsonResponse|string|null
     */
    protected function requiredParam(string $name)
    {
        if (! $this->request->has($name)) {
            throw new \Source\Lib\Api\ApiControllerException(
                $this->request->path(),
                $this->request->toArray(),
                "Param $name is required"
            );
        }

        return $this->request->input($name);
    }

    /**
     * Сформировать ответ
     *
     * @param  bool  $success - успешность запрос
     * @param  int  $status - HTTP код
     * @param  string  $message - сообщение
     * @param $data - данные
     */
    protected function response(bool $success, int $status = 200, string $message = '', array $data = []): JsonResponse
    {
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data], $status);
    }
}
