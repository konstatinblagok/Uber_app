<?php

namespace Database\Seeders;

use App\Models\MenuCategory;
use Illuminate\Database\Seeder;

class MenuCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MenuCategory::insert([
            ['name'=>'Starters', 'description'=>'This is an category item on your menu. Give your item a brief description', 'display_order'=>1],
            ['name'=>'Mains', 'description'=>'This is an category item on your menu. Give your item a brief description', 'display_order'=>2],
            ['name'=>'Dessets', 'description'=>'This is an category item on your menu. Give your item a brief description', 'display_order'=>3],
        ]);
    }
}
