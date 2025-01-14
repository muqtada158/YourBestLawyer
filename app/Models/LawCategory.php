<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawCategory extends Model
{
    use HasFactory;

    public function subCategories()
    {
        return $this->hasMany(LawSubCategory::class, 'cat_id', 'id');
    }
}
