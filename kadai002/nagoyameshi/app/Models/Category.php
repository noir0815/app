<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    //カテゴリは複数のレストランを持つ
    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

}
