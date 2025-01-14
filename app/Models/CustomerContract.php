<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerContract extends Model
{
    use HasFactory;

    protected $casts = [
        'customer_id' => 'integer',
        'attorney_id' => 'integer',
        'contract_id' => 'integer',
        'case_id' => 'integer',
    ];

    //accessors for dates conversions
    public function getConvicteeDateAttribute($value)
    {
        return Carbon::parse($value)->format('m-d-Y');
    }

    // Mutator for date conversion
    public function setConvicteeDateAttribute($value)
    {
        $this->attributes['convictee_date'] = Carbon::createFromFormat('m-d-Y', $value)->format('Y-m-d');
    }

    // accessors for date conversion
    public function getContractDateAttribute($value)
    {
        return Carbon::parse($value)->format('m-d-Y');
    }

    // Mutator for date conversion
    public function setContractDateAttribute($value)
    {
        $this->attributes['contract_date'] = Carbon::createFromFormat('m-d-Y', $value)->format('Y-m-d');
    }

    //relations
    public function getAttornies()
    {
        return $this->hasOne(User::class, 'id', 'attorney_id');
    }
    public function getCustomer()
    {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }
    public function getCaseDetail()
    {
        return $this->hasOne(CaseDetail::class, 'id', 'case_id');
    }
    public function getContract()
    {
        return $this->hasOne(Contracts::class, 'id', 'contract_id');
    }
    public function getPaymentPlan()
    {
        return $this->hasOne(PaymentPlan::class, 'case_id', 'case_id')
        ->where('status', 'Enabled');
    }
    public function caseAttorneyBid()
    {
        return $this->hasOne(CaseAttornies::class, 'case_id', 'case_id')
            ->whereColumn('attorney_id', 'attorney_id');
    }
    public function caseOngoingCases()
    {
        return $this->hasOne(CaseDetail::class, 'id', 'case_id')
            ->where('case_status', 'Accepted');
    }
}
