<?php

namespace Database\Seeders;

use App\Consts\CommonConst;
use App\Models\Experts\ExpertProfile;
use App\Models\Users\User;
use App\Models\Users\UserProfile;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    public function run()
    {
        DB::table('users')->insert([
            [
                'last_name' => '斎藤',
                'first_name' => '裕太',
                'last_name_kana' => 'サイトウ',
                'first_name_kana' => 'ユウタ',
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
                'mail_magazine_flag' => '1',
                'created_at' => Carbon::now(),
                'created_by' => 'seeder',
                'updated_at' => Carbon::now(),
                'updated_by' => 'seeder',
            ]
        ]);

        User::factory()->state(new Sequence(
          ['mail_magazine_flag' => '0'],
          ['mail_magazine_flag' => '1'],
        ))->count(CommonConst::USER_COUNT)->create();
    }
}
