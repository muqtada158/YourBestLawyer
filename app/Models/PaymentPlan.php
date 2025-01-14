<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentPlan extends Model
{
    use HasFactory;
    protected $casts = [
        'customer_id' => 'integer',
        'attorney_id' => 'integer',
        'case_id' => 'integer',
        'sub_cat_id' => 'integer',
        'package_id' => 'integer',
        'invoice_no' => 'integer',
        'total_amount' => 'decimal:2',
        'installment_cycle' => 'integer',
    ];

    public function getCaseDetails()
    {
        return $this->hasOne(CaseDetail::class, 'id', 'case_id');
    }
    public function getTransactions()
    {
        return $this->hasMany(Transactions::class, 'payment_plan_id', 'id');
    }
    public function getTransactionDownpayment()
    {
        return $this->hasOne(Transactions::class, 'payment_plan_id', 'id')
                    ->where('installment_cycle_no', 0);
    }


}
