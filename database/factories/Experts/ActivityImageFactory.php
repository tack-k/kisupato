<?php

namespace Database\Factories\Experts;

use Illuminate\Database\Eloquent\Factories\Factory;
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
}
