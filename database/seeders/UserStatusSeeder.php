<?php

namespace Database\Seeders;

use App\Models\UserStatus;
use Illuminate\Database\Seeder;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserStatus::insert([
            ['name' => 'Pending Approval'],
            ['name' => 'Approved'],
            ['name' => 'Blocked'],
            ['name' => 'Deleted'],
        ]);
    }
}
