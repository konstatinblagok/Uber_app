<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name' => 'John Admin',
                'email' => 'admin@domain.com',
                'password' => Hash::make('password'),
                'address' => '8681 NW. Bay Meadows Street Stuart, FL 34997',
                'picture_url' => '/site/images/default-user.jpg',
                'phone' => '+18143519500',
                'biography' => '',
                'type' => 'u_admin',
                'is_active' => true,
            ], [
                'name' => 'John Cook',
                'email' => 'cook@domain.com',
                'password' => Hash::make('password'),
                'address' => '8681 NW. Bay Meadows Street Stuart, FL 34997',
                'picture_url' => '/site/images/default-user.jpg',
                'phone' => '+18143519500',
                'biography' => '',
                'type' => 'u_cook',
				'is_active' => true,
            ]
        ]);
    }
}
