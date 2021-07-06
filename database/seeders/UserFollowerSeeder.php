<?php

namespace Database\Seeders;

use App\Models\UserFollower;
use Illuminate\Database\Seeder;

class UserFollowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserFollower::insert([
            ['follower_user_id'=>2, 'following_user_id'=>3],
            ['follower_user_id'=>2, 'following_user_id'=>4],
            ['follower_user_id'=>3, 'following_user_id'=>2],
        ]);
    }
}
