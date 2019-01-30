<?php

namespace App\Console;

use App\Models\Backup\backupschedule;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        Commands\WardBed::class,
    ];


    protected function schedule(Schedule $schedule)
    {
        $schedule->command('ward:bed')->cron('0 */23 * * *');
    }

    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
