<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class UserDetail extends Model
{
    use HasFactory;

    protected $casts = [
        'user_id' => 'integer',
    ];

    // Accessor for date conversion
    public function getDobAttribute($value)
    {
        return Carbon::parse($value)->format('m-d-Y');
    }
    public function setDobAttribute($value)
    {
        $this->attributes['dob'] = Carbon::createFromFormat('m-d-Y', $value)->format('Y-m-d');
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
