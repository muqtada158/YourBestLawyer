<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseAttornies extends Model
{
    use HasFactory;

    protected $casts = [
        'case_id' => 'integer',
        'attorney_id' => 'integer',
        'attorney_bid' => 'decimal:2'
    ];

    public function getAttornies()
    {
        return $this->hasOne(User::class, 'id', 'attorney_id');
    }
    public function getCaseDetails()
    {
        return $this->hasOne(CaseDetail::class, 'id', 'case_id');
    }

}
