<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseMedia extends Model
{
    use HasFactory;

    protected $casts = [
        'user_id' => 'integer',
        'case_id' => 'integer',
    ];

    public function getCaseDetail()
    {
        return $this->hasOne(CaseDetail::class, 'id', 'case_id');
    }
}
