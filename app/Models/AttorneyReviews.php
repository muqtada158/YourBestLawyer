<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttorneyReviews extends Model
{
    use HasFactory;

    // Mutators for date conversions
    public function setGoogleDateAttribute($value)
    {
        $this->attributes['google_date'] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function setYelpDateAttribute($value)
    {
        $this->attributes['yelp_date'] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function setTrustPilotDateAttribute($value)
    {
        $this->attributes['trust_pilot_date'] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

}
