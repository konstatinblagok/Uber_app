<?php

namespace Database\Seeders;

use App\Models\ReviewBasedCharge;
use Illuminate\Database\Seeder;

class ReviewBasedChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReviewBasedCharge::insert([
            ['rating_number' => 3, 'currency_id' => 1, 'price' => 2],
            ['rating_number' => 4, 'currency_id' => 1, 'price' => 3],
            ['rating_number' => 5, 'currency_id' => 1, 'price' => 4],
        ]);
    }
}
