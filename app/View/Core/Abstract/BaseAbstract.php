<?php

namespace App\View\Core\Abstract;

abstract class BaseAbstract extends \Illuminate\View\Component
{
    /**
     * Получаем значение, проверяя, если ли оно в списке разрешенных
     *  если да, то возвращаем его
     *  иначе - значение по умолчанию
     *
     * @param string $code - ключ для получения значения из разрешенных значений
     * @param array $allowed - разрешенные значения
     * @param string $default - значение по умолчанию
     * @param bool $checkByKey - проверяем по ключу или значению в массиве
     * @return mixed|string
     */
    protected function getAllowedValue(string $code, array $allowed, string $default = '',
                                       bool $checkByKey = true) {
        $value = $default;

        if ($this->checkPropAllowed($code, $allowed, $checkByKey) && !empty($code)) {
            $value = $allowed[$code];
        }

        return $value;
    }

    /**
     * Проверяем, есть ли заданное свойство в списке разрешенных для этого компонента
     *
     * @param string $code - заданный ключ
     * @param array $allowed - массив разрешенных значений вида key => value
     * @param bool $checkByKey - проверяем по ключу или значению в массиве
     * @return bool
     */
    protected function checkPropAllowed(string $code, array $allowed, bool $checkByKey) : bool {
        return $checkByKey === true ? array_key_exists($code, $allowed) : in_array($code, $allowed);
    }
}
