<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodType extends Model
{
    use HasFactory;

    public function foodMenuCategory()
    {
        return $this->belongsTo(FoodMenuCategory::class, 'food_menu_category_id', 'id');
    }

    public function meal(){
        
        return $this->hasMany(Meal::class, 'food_type_id');
    }
}
