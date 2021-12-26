<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Experts\Expert;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
           //管理者マスタ系
            AuthoritySeeder::class,
            DepartmentSeeder::class,
            AdminSeeder::class,

            AreaSeeder::class,
            CitySeeder::class,

            ExpertSeeder::class,
        ]);
    }
}
