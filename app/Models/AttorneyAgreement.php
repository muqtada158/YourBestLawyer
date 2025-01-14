<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttorneyAgreement extends Model
{
    use HasFactory;

    // Accessor for date conversion
    public function getDobAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('m-d-Y') : null;
    }
    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('m-d-Y');
    }

    // Mutator for date conversion
    public function setDobAttribute($value)
    {
        $this->attributes['dob'] = Carbon::createFromFormat('m-d-Y', $value)->format('Y-m-d');
    }
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::createFromFormat('m-d-Y', $value)->format('Y-m-d');
    }


    //relations
    public function attorneyApplication()
    {
        return $this->belongsTo(AttorneyApplication::class);
    }
}
