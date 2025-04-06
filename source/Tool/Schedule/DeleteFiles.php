<?php

namespace Source\Tool\Schedule;

use Source\Lib\FileStorage;

/**
 * Выполнить удаление файлов, которые помечены к удалению
 */
class DeleteFiles implements ScheduleInterface
{
    public function __invoke(): void
    {
        $fs = new FileStorage();
        $fs->fullDelete();
    }
}
