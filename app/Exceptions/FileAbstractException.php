<?php

namespace App\Exceptions;

use ReflectionMethod;
use ReflectionException;

/**
 * Класс оболочка для обрабтки исключений при работае с файлами
 * основаня концепция таков:
 *  1. Получаем настройки для вызова исключения (параметр options в конструктуре)
 *  2. Получаем код ошибки
 *      код ошибки связан с названием метода для его вызова (создает алиас)
 *  3. Вызываем метод для формирования сообщения исключения
 *      если работы метода нужен конфиг, то он беретяс из options, или же задается значение по умолчанию
 *      Вызывается языковая строка, которая создает понятное пользователю сообщение
 *
 */
abstract class FileAbstractException extends \Exception
{
    const UNDEFINED = 100;

    const LANG_ID = 'exception.filestorage.upload';

    /**
     * @param array $options - данные для обработки исключения
     * @param int $code - код ошибки
     * @param Throwable|null $previous
     */
    public function __construct(private array $options = [], int $code = 0, ?Throwable $previous = null)
    {
        $method = $this->code_aliases()[static::UNDEFINED];
        if (!empty($this->code_aliases()[$code])) {
            $method = $this->code_aliases()[$code];
        }

        parent::__construct($this->{$method}(), $code, $previous);
    }

    /**
     * Сопоставление кода ошибки с его названием, где название - это название метода для формирования сообщения
     * об ошибке
     *
     * @return array
     */
    abstract protected function code_aliases(): array;

    /**
     * Неизвестная ошибка
     *
     * @return string
     * @throws ReflectionException
     */
    protected function undefined(): string {
        return $this->get_lang($this->getMethodShortName(__METHOD__));
    }

    /**
     * Получаем короткное название метода для вызова сообщения исключения
     *
     * @param $methodname - полное название метода
     * @return string
     * @throws ReflectionException
     */
    protected function getMethodShortName($methodname): string {
        try {
            $reflection = new ReflectionMethod($methodname);
        } catch (ReflectionException $exception) {
            $reflection = new ReflectionMethod($this, static::UNDEFINED);
        } catch (\Exception $exception) {
            throw new $exception;
        }

        return $reflection->getShortName();
    }

    /**
     * Получение необходимых настроек для формирования исключения
     *
     * @param $methodname
     * @param $key
     * @param $default
     * @return false|mixed
     * @throws ReflectionException
     */
    protected function retrieveOption($methodname, $key, $default) {
        $option = $this->options[$this->getMethodShortName($methodname)];
        if (!empty($option)) {
            if (!empty($option[$key])) {
                return $option[$key];
            }
        }

        return $default;
    }



    protected function get_lang(string $key): string {
        return __(static::LANG_ID . ".$key");
    }

}
