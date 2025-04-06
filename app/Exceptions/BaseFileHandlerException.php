<?php

namespace App\Exceptions;

use ReflectionException;
use Illuminate\Support\Arr;

require_once base_path('source/Helper/AppLib.php');

class BaseFileHandlerException extends FileAbstractException
{
    const INVALID_EXTENSION = 101;
    const FILE_SIZE_LIMIT = 103;
    const SAVING_ERROR = 102;

    /**
     * Неверное расширение
     *
     * @return string
     * @throws ReflectionException
     */
    protected function invalid_extension(): string {
        $text = $this->get_lang($this->getMethodShortName(__METHOD__));
        $needle = $this->retrieveOption(__METHOD__, 'needle',
            Arr::flatten(config('filesystems.upload.extension')));

       if (is_array($needle) || is_string($needle)) {
           if (is_array($needle)) {
               $needle = implode(', ', $needle);
           }
       } else {
           $needle = 'undefined error!';
       }

        return $text . " $needle";
    }


    /**
     *
     *
     * @return string
     * @throws ReflectionException
     */
    protected function saving_error(): string {
        return $this->get_lang($this->getMethodShortName(__METHOD__));
    }

    /**
     * Превышен лимит на размер файла
     *
     * @return string
     * @throws ReflectionException
     */
    protected function file_size_limit(): string {
        $text = $this->get_lang($this->getMethodShortName(__METHOD__));
        $default = config('filesystems.upload.size.max_file_size');
        $maxSize = formatBytes($this->retrieveOption(__METHOD__, 'max', $default));

        return $text . " $maxSize";
    }

    protected function code_aliases(): array {
        return [
            static::UNDEFINED => 'undefined',
            static::INVALID_EXTENSION => 'invalid_extension',
            static::SAVING_ERROR => 'saving_error',
            static::FILE_SIZE_LIMIT => 'file_size_limit'
        ];
    }
}
