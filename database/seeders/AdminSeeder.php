<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            [
                'authority_id' => 1,
                'department_id' => 1,
                'staff_number' => '00011121',
                'last_name' => '山田',
                'first_name' => '太郎',
                'last_name_kana' => 'ヤマダ',
                'first_name_kana' => 'タロウ',
                'email' => 'a@a',
                'password' => Hash::make('1111aaaa'),
                'password_init_flag' => 1,
                'created_at' => Carbon::now(),
                'created_by' => 'seeder',
                'updated_at' => Carbon::now(),
                'updated_by' => 'seeder',
            ],
        ]);
    }
}
