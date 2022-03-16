<?php

namespace Database\Factories\Experts;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Carbon;

class ActivityImageFactory extends Factory {
    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'created_by' => 'seeder',
            'updated_at' => Carbon::now(),
            'updated_by' => 'seeder',
        ];
    }

    public function makeActivityImage()
    {
        return $this->state(new Sequence(
            function ($sequence) {
                return ['activity_image' => 'activity_image' . rand(1, 10) . '.jpeg'];
            }
        ));
    }
}
