<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealMedia extends Model
{
    use HasFactory;
    protected $table = 'meals_media';
    protected $fillable = [
        'name',
        'path',
        'size',
        'details',
        'meal_id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function cookFoodMedia()
    {
        return $this->belongsTo(CookFoodMedia::class, 'cook_food_media_id', 'id');
    }
}
