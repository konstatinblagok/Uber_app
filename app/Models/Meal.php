<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Meal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'todays_food',
        'pickup_time',
        'user_id',
        'title',
        'description',
        'price',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'pickup_time'
    ];

    public function user() {

        return $this->belongsTo(User::class, 'user_id');
    }

    public function foodMenuCategory()
    {
        return $this->belongsTo(FoodMenuCategory::class, 'food_category_id', 'id');
    }

    public function foodType()
    {
        return $this->belongsTo(FoodType::class, 'food_type_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function mealMedia() {

        return $this->hasMany(MealMedia::class, 'meal_id');
    }
}
