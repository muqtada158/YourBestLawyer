<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseCounts extends Model
{
    use HasFactory;
    protected $casts = [
        'user_id' => 'integer',
        'total_cases' => 'integer',
        'ongoing_cases' => 'integer',
        'ended_cases' => 'integer',
    ];
}
