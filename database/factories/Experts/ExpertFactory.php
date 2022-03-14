<?php

namespace Database\Factories\Experts;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class ExpertFactory extends Factory {
    public function definition(): array
    {
        return [
            'last_name' => $this->faker->lastName(),
            'first_name' => $this->faker->firstName(),
            'last_name_kana' => $this->faker->lastKanaName(),
            'first_name_kana' => $this->faker->firstKanaName(),
            'email' => $this->faker->email(),
            'tel' => $this->faker->phoneNumber(),
            'postal_code' => $this->faker->postcode(),
            'region' => $this->faker->prefecture(),
            'city' => $this->faker->city(),
            'street' => $this->faker->streetAddress(),
            'building' => $this->faker->secondaryAddress(),
            'gender' => $this->faker->numberBetween(0, 2),
            'birthday' => $this->faker->dateTimeBetween('-80 years', '-20years')->format('Y-m-d'),
            'password' => Hash::make('1111aaaa'),
            'created_at' => Carbon::now(),
            'created_by' => 'seeder',
            'updated_at' => Carbon::now(),
            'updated_by' => 'seeder',
        ];
    }
}
