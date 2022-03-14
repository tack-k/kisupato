<?php

namespace Database\Seeders;

use App\Models\Experts\ActivityImage;
use App\Models\Experts\ExpertProfile;
use App\Models\Experts\Skill;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ExpertProfileSeeder extends Seeder {
    public function run()
    {
        ExpertProfile::factory()->count(101)
            ->state(new Sequence(
                ['profile_image' => 'profile_image1.jpeg'],
                ['profile_image' => 'profile_image2.jpeg'],
                ['profile_image' => 'profile_image3.jpeg'],
                ['profile_image' => 'profile_image4.jpeg'],
                ['profile_image' => 'profile_image5.jpeg'],
                ['profile_image' => 'profile_image6.jpeg'],
                ['profile_image' => 'profile_image7.jpeg'],
                ['profile_image' => 'profile_image8.jpeg'],
                ['profile_image' => 'profile_image9.jpeg'],
                ['profile_image' => 'profile_image10.jpeg'],
            ))
            ->has(Skill::factory()->count(3))
            ->has(ActivityImage::factory()->count(5)
                ->state(new Sequence(
                    ['activity_image' => 'activity_image1.jpeg'],
                    ['activity_image' => 'activity_image2.jpeg'],
                    ['activity_image' => 'activity_image3.jpeg'],
                    ['activity_image' => 'activity_image4.jpeg'],
                    ['activity_image' => 'activity_image5.jpeg'],
                )))
            ->create();
    }
}
