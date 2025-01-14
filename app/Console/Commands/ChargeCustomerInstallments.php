<?php

namespace App\Console\Commands;

use App\Http\Controllers\CronJobController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ChargeCustomerInstallments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:charge-customer-installments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Charge customer installments';

    /**
     * Execute the console command.
     */
    public function handle(CronJobController $cronJobController)
    {
        $response = $cronJobController->chargeCustomerInstallments();
        Log::info('Customer installments charged successfully!', ['response' => $response]);
    }
}
