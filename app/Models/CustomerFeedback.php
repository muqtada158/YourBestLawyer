<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerFeedback extends Model
{
    use HasFactory;

    protected $casts = [
        'case_id' => 'integer',
        'customer_id' => 'integer',
        'attorney_id' => 'integer',
        'rating' => 'float',
    ];

    public function getAttorney()
    {
        return $this->hasOne(User::class, 'id', 'attorney_id');
    }
}
