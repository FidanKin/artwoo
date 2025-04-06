<?php

namespace Source\Tool\Schedule;

interface ScheduleInterface
{
    /**
     * Данный метод вызывается в планировщике, здесь определяется выполняемое действие
     *
     * @return void
     */
    public function __invoke(): void;
}
