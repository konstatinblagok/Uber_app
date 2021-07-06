<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::insert([
            ['menu_category_id'=> 1, 'name'=>'3 Tomatoes Salad', 'description'=>'This is an item on your menu. Give your item a brief description', 'price'=>11, 'currency_id'=>1],
            ['menu_category_id'=> 2, 'name'=>'Multi-Greens Salad', 'description'=>'This is an item on your menu. Give your item a brief description', 'price'=>10, 'currency_id'=>1],
            ['menu_category_id'=> 2, 'name'=>'Kale Caesar', 'description'=>'This is an item on your menu. Give your item a brief description', 'price'=>21, 'currency_id'=>2],
            ['menu_category_id'=> 1, 'name'=>'Goat Cheese with Asparagus', 'description'=>'This is an item on your menu. Give your item a brief description', 'price'=>5, 'currency_id'=>1],
            ['menu_category_id'=> 1, 'name'=>'Hummus Tahina', 'description'=>'This is an item on your menu. Give your item a brief description', 'price'=>16, 'currency_id'=>2],
            ['menu_category_id'=> 3, 'name'=>'Roasted Cauliflower', 'description'=>'This is an item on your menu. Give your item a brief description', 'price'=>4, 'currency_id'=>1],
            ['menu_category_id'=> 2, 'name'=>'Wild Rice with Broccoli', 'description'=>'This is an item on your menu. Give your item a brief description', 'price'=>7, 'currency_id'=>2],
            ['menu_category_id'=> 1, 'name'=>'Roasted Spicy Root Vegetables', 'description'=>'This is an item on your menu. Give your item a brief description', 'price'=>16, 'currency_id'=>1],
        ]);
    }
}
