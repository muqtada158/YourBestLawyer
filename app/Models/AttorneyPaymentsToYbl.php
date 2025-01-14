<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttorneyPaymentsToYbl extends Model
{
    use HasFactory;
    public function getAttorney()
    {
        return $this->hasOne(User::class, 'id', 'attorney_id');
    }
}
