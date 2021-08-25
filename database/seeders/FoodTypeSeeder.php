<?php

namespace Database\Seeders;

use App\Models\FoodType;
use Illuminate\Database\Seeder;

class FoodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FoodType::insert([
            ['food_menu_category_id' => 1, 'name' => 'Meat', 'currency_id' => 1, 'price' => 6],
            ['food_menu_category_id' => 2, 'name' => 'Fish', 'currency_id' => 1, 'price' => 7],
            ['food_menu_category_id' => 1, 'name' => 'Pasta', 'currency_id' => 1, 'price' => 4],
            ['food_menu_category_id' => 2, 'name' => 'Vegetarian', 'currency_id' => 1, 'price' => 5],
            ['food_menu_category_id' => 1, 'name' => 'Vegan', 'currency_id' => 1, 'price' => 5],
        ]);
    }
}
