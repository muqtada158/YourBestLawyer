<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    protected $casts = [
        'payment_plan_id' => 'integer',
        'customer_id' => 'integer',
        'attorney_id' => 'integer',
        'case_id' => 'integer',
        'installment_cycle_no' => 'integer',
        'amount' => 'decimal:2',
    ];

    public function getAttornies()
    {
        return $this->hasOne(User::class, 'id', 'attorney_id');
    }
    public function getCustomers()
    {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }
    public function getCaseDetails()
    {
        return $this->hasOne(CaseDetail::class, 'id', 'case_id');
    }
}
