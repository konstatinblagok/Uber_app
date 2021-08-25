<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            
            CurrencySeeder::class,
            UserRoleSeeder::class,
            UserStatusSeeder::class,
            ReviewBasedChargeSeeder::class,
            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            FoodMenuCategorySeeder::class,
            FoodTypeSeeder::class,
            PaymentMethodSeeder::class,
        ]);
    }
}
