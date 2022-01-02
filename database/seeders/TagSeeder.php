<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            '地域',
            '農業',
            '中小企業'
        ];

        foreach ($names as $index => $name) {
            $data[] = [
                'name' => $name,
                'created_at' => Carbon::now(),
                'created_by' => 'seeder',
                'updated_at' => Carbon::now(),
                'updated_by' => 'seeder',
            ];
        }

        DB::table('tags')->insert($data);
    }
}
