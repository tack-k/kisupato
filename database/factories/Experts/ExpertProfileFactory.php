<?php

namespace Database\Factories\Experts;

use App\Models\City;
use App\Services\CommonService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ExpertProfileFactory extends Factory {

    private static $sequence = 1;

    public function definition(): array
    {

        $activityBase = City::all()->random();

        $commonService = new CommonService();

        return [
            'expert_id' => function () {
                return self::$sequence++;
            },
            'status' => 0,
            'nickname' => $this->faker->userName(),
            'profile_image' => 'profile_image1',
            'self_introduction' => $this->faker->realText(80),
            'activity_title' => $this->faker->realText(25),
            'activity_content' => $this->faker->realText(150),
            'activity_base' => $activityBase,
            'latitude' => $activityBase['latitude'] . $commonService->generateRandomNumbers(4),
            'longitude' => $activityBase['longitude'] . $commonService->generateRandomNumbers(4),
            'created_at' => Carbon::now(),
            'created_by' => 'seeder',
            'updated_at' => Carbon::now(),
            'updated_by' => 'seeder',
        ];
    }
}
