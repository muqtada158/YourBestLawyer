<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        //this command is to charge installments
        $schedule->command('app:charge-customer-installments')->everyFiveSeconds();

        // //this command is to delete contract if not accepted after 48 hourss
        $schedule->command('app:delete-contract-after48-hours')->hourly();

        // //this command is to delete case after 48 hours of no bidding received
        $schedule->command('app:delete-first-case-after48-hours')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
