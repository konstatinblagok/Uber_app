<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CookFoodMedia extends Model
{
    use HasFactory;

    public function mealMedia() {

        return $this->hasOne(MealMedia::class, 'cook_food_media_id');
    }
}
