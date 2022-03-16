<?php

namespace Database\Factories\Users;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserProfileFactory extends Factory {

    private static $sequence = 1;

    public function definition(): array
    {
        return [
            'user_id' => function () {
                return self::$sequence++;
            },
            'nickname' => $this->faker->firstName() . rand(1, 100),
            'profile_image' => 'default_profile.png',
            'self_introduction' => $this->faker->realText(80),
            'created_at' => Carbon::now(),
            'created_by' => 'seeder',
            'updated_at' => Carbon::now(),
            'updated_by' => 'seeder',
        ];
    }

}
