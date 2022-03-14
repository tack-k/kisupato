<?php

namespace Database\Seeders;

use App\Models\Experts\Expert;
use App\Models\Experts\ExpertProfile;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ExpertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('experts')->insert([
            [
                'last_name' => '佐藤',
                'first_name' => '太郎',
                'last_name_kana' => 'サトウ',
                'first_name_kana' => 'タロウ',
                'email' => 'a@a',
                'tel' => '09011112222',
                'postal_code' => '3800801',
                'region' => '長野県',
                'city' => '長野市',
                'street' => '箱清水1-1',
                'building' => 'コーポさくら101',
                'gender' => '0',
                'birthday' => '20000101',
                'password' => Hash::make('1111aaaa'),
                'created_at' => Carbon::now(),
                'created_by' => 'seeder',
                'updated_at' => Carbon::now(),
                'updated_by' => 'seeder',
            ]
        ]);

        Expert::factory()->count(100)->create();
    }
}
