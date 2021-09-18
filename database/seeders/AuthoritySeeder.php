<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AuthoritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('authorities')->insert([
            [
                'name' => '全体管理ユーザー',
                'content' => 'すべての権限を有するユーザー',
                'created_at' => Carbon::now(),
                'created_by' => 'seeder',
                'updated_at' => Carbon::now(),
                'updated_by' => 'seeder',
            ],
            [
                'name' => '部署管理ユーザー',
                'content' => '部局情報の変更権限を有するユーザー',
                'created_at' => Carbon::now(),
                'created_by' => 'seeder',
                'updated_at' => Carbon::now(),
                'updated_by' => 'seeder',
            ],
            [
                'name' => '一般ユーザー',
                'content' => '重要事項の変更権限がないユーザー',
                'created_at' => Carbon::now(),
                'created_by' => 'seeder',
                'updated_at' => Carbon::now(),
                'updated_by' => 'seeder',
            ],

        ]);
    }
}
