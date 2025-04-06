<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Source\Entity\User\Models\User;
use Source\Tool\Schedule\DeleteFiles;

class Handler
{
    public function __invoke(Schedule $schedule): void
    {
        $schedule->call(new DeleteFiles())->hourly();
        $schedule->command('model:prune', ['--model' => User::class])->everyFifteenMinutes();
    }
}
