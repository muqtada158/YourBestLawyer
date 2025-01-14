<?php

namespace App\Console\Commands;

use App\Http\Controllers\CronJobController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteContractAfter48Hours extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-contract-after48-hours';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete contract after 48 hours if not accepted.';

    /**
     * Execute the console command.
     */
    public function handle(CronJobController $cronJobController)
    {
        $response = $cronJobController->deleteContractAfter48Hours();
        Log::info('Contract deleted after 48 hours successfully!', ['response' => $response]);
    }
}
