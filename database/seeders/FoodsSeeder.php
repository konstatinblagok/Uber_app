<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Seeder;

class FoodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Food::insert([
            ['id'=>'food_fish' , 'name'=>'fish', 'description'=>''],
            ['id'=>'food_meat' , 'name'=>'Meat', 'description'=>''],
            ['id'=>'food_pasta' , 'name'=>'Pasta', 'description'=>''],
            ['id'=>'food_veg' , 'name'=>'Vegan Vegetarian', 'description'=>''],
        ]);
    }
}
