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

    public function cook() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function media(){
        return $this->hasMany(MealMedia::class, 'meal_id');
    }

    public function cover(){
        $cover = $this->media()
            ->where('name' ,'LIKE', '%.jpg')
            ->orWhere('name' ,'LIKE', '%.jpeg')
            ->orWhere('name' ,'LIKE', '%.png')
            ->orWhere('name' ,'LIKE', '%.bmp')
            ->first();
        return isset($cover) ? $cover->path : '/site/images/img-01.jpg';
    }

    public function type(){
        return $this->hasOne(Food::class, 'id', 'todays_food');
    }

    public static function getTodaysMeal(){
        return Meal::where('user_id', Auth::id())->whereDate('created_at',now())->get();
    }
}
