<?php

namespace Database\Seeders;

use App\Consts\CommonConst;
use App\Models\Users\UserProfile;
use Illuminate\Database\Seeder;

class UserProfileSeeder extends Seeder {
    public function run()
    {
        UserProfile::factory()->count(CommonConst::USER_COUNT + CommonConst::ORIGINAL_USER_COUNT)->create();
    }
}
