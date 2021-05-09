<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserType::insert([
            ['id' => 'u_admin', 'name' => 'Admin user', 'description' => ''],
            ['id' => 'u_cook', 'name' => 'Cook', 'description' => ''],
            ['id' => 'u_customer', 'name' => 'Customer', 'description' => ''],
        ]);
    }
}
