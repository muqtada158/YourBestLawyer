<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawSubCategory extends Model
{
    use HasFactory;
    protected $casts = [
        'cat_id' => 'integer',
        'installments' => 'integer',
    ];

    public function getLaywers()
    {
        return $this->hasMany(Lawyer::class, 'sub_cat_id', 'id');
    }
    
    public function getCategory()
    {
        return $this->hasOne(LawCategory::class, 'id', 'cat_id');
    }

}
