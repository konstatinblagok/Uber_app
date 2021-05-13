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
        'created_at',
        'updated_at',
    ];
    public function media(){
        return $this->hasMany(MealMedia::class, 'meal_id');
    }

    public static function getTodaysMeal(){
        return Meal::where('user_id', Auth::id())->whereDate('created_at',now())->first();
    }
}
