<?php

namespace App\Console;

use App\Console\Commands\Deploy;
use App\Console\Commands\ImportDBaseCommand;
use App\Console\Commands\UpdatePermissionsTable;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        ImportDBaseCommand::class,
        Deploy::class,
        UpdatePermissionsTable::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('backup:run')
            ->dailyAt('01:00');
    }
}
