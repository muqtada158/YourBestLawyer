<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttorneyType extends Model
{
    use HasFactory;

    public function getAttorney()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getCaseLaw()
    {
        return $this->hasOne(LawCategory::class, 'id', 'law_cat_id');
    }

    public function getCasePackage()
    {
        return $this->hasOne(Lawyer::class, 'id', 'lawyer_id');
    }
}
