<?php

namespace Database\Factories\Experts;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SkillFactory extends Factory {
    public function definition(): array
    {
        return [
            'skill_title' => $this->faker->realText(20),
            'skill_content' => $this->faker->realText(100),
            'created_at' => Carbon::now(),
            'created_by' => 'seeder',
            'updated_at' => Carbon::now(),
            'updated_by' => 'seeder',
        ];
    }
}
