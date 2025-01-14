<?php

namespace App\Console\Commands;

use App\Http\Controllers\CronJobController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteFirstCaseAfter48Hours extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-first-case-after48-hours';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete first case after 48 hours.';

    /**
     * Execute the console command.
     */
    public function handle(CronJobController $cronJobController)
    {
        $response = $cronJobController->deleteFirstCaseAfter48Hours();
        Log::info('Case deleted after 48 hours successfully!', ['response' => $response]);
    }
}
