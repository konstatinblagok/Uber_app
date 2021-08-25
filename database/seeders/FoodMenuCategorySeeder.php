<?php

namespace Database\Seeders;

use App\Models\FoodMenuCategory;
use Illuminate\Database\Seeder;

class FoodMenuCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FoodMenuCategory::insert([
            ['name' => 'Starter', 'description' => 'lorem ipsum'],
            ['name' => 'Main', 'description' => 'lorem ipsum'],
            ['name' => 'Dessert', 'description' => 'lorem ipsum'],
        ]);
    }
}
