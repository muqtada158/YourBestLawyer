<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttorneyApplication extends Model
{
    use HasFactory;

    public function getAttorneyApplicationMedia()
    {
        return $this->hasMany(AttorneyMedia::class, 'attorney_application_id', 'id');
    }

    public function attorneyAgreement()
    {
        return $this->hasOne(AttorneyAgreement::class);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
