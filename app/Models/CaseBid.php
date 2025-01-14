<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseBid extends Model
{
    use HasFactory;

    protected $casts = [
        'user_id' => 'integer',
        'case_id' => 'integer',
        'bid' => 'decimal:2'
    ];
}
