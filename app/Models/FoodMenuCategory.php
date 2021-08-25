<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodMenuCategory extends Model
{
    use HasFactory;

    public function foodType(){
        
        return $this->hasMany(FoodType::class, 'food_menu_category_id');
    }
}
