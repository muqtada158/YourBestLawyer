<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $casts = [
        'case_sr_no' => 'integer',
        'customer_id' => 'integer',
        'attorney_id'=> 'integer',
        'case_type'=> 'integer',
    ];

    // Accessor for date conversion
    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('m-d-Y');
    }

    // Mutator for date conversion
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::createFromFormat('m-d-Y', $value)->format('Y-m-d');
    }

    public function getAttornies()
    {
        return $this->hasOne(User::class, 'id', 'attorney_id');
    }
    public function getCustomers()
    {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }
}
