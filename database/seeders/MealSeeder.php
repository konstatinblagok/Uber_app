<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\Meal;
use App\Models\MealMedia;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $food_types = Food::all();
        $food_type_count = count($food_types);
        $cook_id = User::where('type', 'u_cook')->first()->id;
        $meal_date_time = Carbon::parse('05:30 PM')->addMonth(6);

        for($i=1; $i <= 10; $i++){
            $food_type = $food_types[$i % $food_type_count];

            $meal = Meal::create([
                "todays_food" => $food_type->id,
                "pickup_time" => $meal_date_time,
                "user_id" => 7,
            ]);

            MealMedia::create([
                "name" => "blog-img-01.jpg",
                "path" => "/site/images/blog-img-01.jpg",
                "size" => "66937",
                "details" => "",
                "meal_id" => $meal->id,
                "user_id" => $cook_id,
            ]);
        }
    }
}
