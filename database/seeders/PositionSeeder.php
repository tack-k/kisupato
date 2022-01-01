<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            '地域づくりコーディネーター',
            'ジビエマイスター',
            '中小企業診断士'
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

        DB::table('positions')->insert($data);
    }
}
