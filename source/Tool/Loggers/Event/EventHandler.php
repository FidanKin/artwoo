<?php

namespace Source\Tool\Loggers\Event;

use Illuminate\Support\Facades\DB;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;
use Source\Tool\Loggers\Exceptions\LoggerInvalidArgumentException;

class EventHandler extends AbstractProcessingHandler
{
    private array $requiredFields = [
        'event_name',
        'component',
        'action',
        'crud',
        'user_id',
        'created_at'
    ];

    protected function write(LogRecord $record): void
    {
        try {
            $this->checkRequiredFields(array_keys($record->context));
            DB::table('event_logs')->insert($record->context);
        } catch(\Exception $exception) {
            throw new LoggerInvalidArgumentException($this, 'check_fields|Insert_in_db', $exception->getMessage());
        }
    }

    private function checkRequiredFields(array $checking): \Throwable|bool {
        if(!empty(array_diff($this->requiredFields, $checking))) {
            return throw new LoggerInvalidArgumentException($this, 'checkRequiredFields');
        };

        return true;
    }
}
