<?php

namespace App\Http\Traits;

use App\Models\AttorneyPaymentsToYbl;
use App\Models\CaseDetail;
use App\Models\PaymentPlan;

trait NumberGeneratorTrait
{
/**
 * Generates a unique serial number by incrementing the maximum 'sr_no' from the CaseDetail table.
 *
 * The serial number is calculated by taking the highest existing 'sr_no' and adding 1 to it.
 * If the resulting number is less than 10000, it will return 10000 as the minimum value.
 *
 * @return int Returns a unique serial number.
 */

    public function uniqueNumberGenerator()
    {
        $nextSerialNumber = CaseDetail::max('sr_no') + 1;
        $uniqueNumber = $nextSerialNumber >= 10000 ? $nextSerialNumber : 10000;

        return $uniqueNumber;
    }

/**
 * Generates a unique invoice number by incrementing the maximum 'invoice_no' from the PaymentPlan table.
 *
 * The invoice number is calculated by taking the highest existing 'invoice_no' and adding 1 to it.
 * If the resulting number is less than 1000000, it will return 1000000 as the minimum value.
 *
 * @return int Returns a unique invoice number.
 */

    public function uniqueInvoiceNumberGenerator()
    {
        $nextSerialNumber = PaymentPlan::max('invoice_no') + 1;
        $uniqueNumber = $nextSerialNumber >= 1000000 ? $nextSerialNumber : 1000000;

        return $uniqueNumber;
    }

/**
 * Generates a unique invoice number for attorneys by incrementing the maximum 'invoice_no' from the AttorneyPaymentsToYbl table.
 *
 * The invoice number is calculated by taking the highest existing 'invoice_no' and adding 1 to it.
 * If the resulting number is less than 2000000, it will return 2000000 as the minimum value.
 *
 * @return int Returns a unique invoice number for attorneys.
 */
    public function uniqueInvoiceNumberGeneratorForAttorney()
    {
        $nextSerialNumber = AttorneyPaymentsToYbl::max('invoice_no') + 1;
        $uniqueNumber = $nextSerialNumber >= 2000000 ? $nextSerialNumber : 2000000;

        return $uniqueNumber;
    }
}
