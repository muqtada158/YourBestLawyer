<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttorneyMedia extends Model
{
    use HasFactory;
    protected $casts = [
        'user_id' => 'integer',
        'attorney_application_id' => 'integer',
    ];
}
