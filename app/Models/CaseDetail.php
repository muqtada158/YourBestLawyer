<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseDetail extends Model
{
    use HasFactory;

    protected $casts = [
        'user_id' => 'integer',
        'sr_no' => 'integer',
        'case_type'=> 'integer',
        'case_sub_type'=> 'integer',
        'package_type'=> 'integer',
        'is_same_person'=> 'integer',
    ];

    //accessors for dates conversions
    public function getConvicteeDobAttribute($value)
    {
        return Carbon::parse($value)->format('m-d-Y');
    }
    public function getClientDobAttribute($value)
    {
        return Carbon::parse($value)->format('m-d-Y');
    }
    public function getNextCourtDateAttribute($value)
    {
        return Carbon::parse($value)->format('m-d-Y');
    }

    // Mutators for date conversions
    public function setConvicteeDobAttribute($value)
    {
        $this->attributes['convictee_dob'] = Carbon::createFromFormat('m-d-Y', $value)->format('Y-m-d');
    }

    public function setClientDobAttribute($value)
    {
        $this->attributes['client_dob'] = Carbon::createFromFormat('m-d-Y', $value)->format('Y-m-d');
    }

    public function setNextCourtDateAttribute($value)
    {
        $this->attributes['next_court_date'] = Carbon::createFromFormat('m-d-Y', $value)->format('Y-m-d');
    }


    //relations
    public function getCaseMedia()
    {
        return $this->hasMany(CaseMedia::class, 'case_id', 'id');
    }
    public function getCaseBid()
    {
        return $this->hasOne(CaseBid::class, 'case_id', 'id');
    }
    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function getCaseLaw()
    {
        return $this->hasOne(LawCategory::class, 'id', 'case_type');
    }
    public function getCaseLawSub()
    {
        return $this->hasOne(LawSubCategory::class, 'id', 'case_sub_type');
    }
    public function getCasePackage()
    {
        return $this->hasOne(Lawyer::class, 'id', 'package_type');
    }
    public function getCaseAttornies()
    {
        return $this->hasMany(CaseAttornies::class, 'id', 'case_id');
    }
    public function getCustomerContract()
    {
        return $this->hasMany(CustomerContract::class, 'case_id', 'id');
    }
    public function getCustomerContractAccepted()
    {
        return $this->hasOne(CustomerContract::class, 'case_id', 'id')->where('status', 'Accepted');
    }
    public function getAcceptedCustomerContracts()
    {
        return $this->hasOne(CustomerContract::class, 'case_id', 'id')
                    ->where('status', 'Accepted');
    }
    public function getPaymentPlan()
    {
        return $this->hasMany(PaymentPlan::class, 'case_id', 'id');
    }
    public function getDynamicFormValues()
    {
        return $this->hasOne(DynamicFormValues::class, 'case_id', 'id');
    }

}
