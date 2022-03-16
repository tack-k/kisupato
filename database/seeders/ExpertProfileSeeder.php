<?php

namespace Database\Seeders;

use App\Consts\CommonConst;
use App\Models\Admins\Position;
use App\Models\Admins\Tag;
use App\Models\Experts\ActivityImage;
use App\Models\Experts\ExpertProfile;
use App\Models\Experts\Skill;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ExpertProfileSeeder extends Seeder {
    public function run()
    {
        ExpertProfile::factory()->count(CommonConst::EXPERT_COUNT + CommonConst::ORIGINAL_EXPERT_COUNT)
            ->has(Skill::factory()->count(3))
            ->has(ActivityImage::factory()->makeActivityImage()->count(5)
            )
            ->hasAttached(Tag::all()->random(2))
            ->hasAttached(Position::all()->random(1))
            ->create();
    }
}
