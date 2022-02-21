<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dish extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo("App\Models\Category", "category_id");
    }
}
