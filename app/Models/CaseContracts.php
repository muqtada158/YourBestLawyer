<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseContracts extends Model
{
    use HasFactory;
    public function getCaseLaw()
    {
        return $this->hasOne(LawCategory::class, 'id', 'cat_id');
    }
}
