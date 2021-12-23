<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            [
                'area_id' => 1,
                'name' => '中野市'
            ],
            [
                'area_id' => 1,
                'name' => '飯山市'
            ],
            [
                'area_id' => 1,
                'name' => '山ノ内町'
            ],
            [
                'area_id' => 1,
                'name' => '木島平村'
            ],
            [
                'area_id' => 1,
                'name' => '野沢温泉村'
            ],
            [
                'area_id' => 1,
                'name' => '栄村'
            ],
            [
                'area_id' => 1,
                'name' => '長野市'
            ],
            [
                'area_id' => 1,
                'name' => '須坂市'
            ],
            [
                'area_id' => 1,
                'name' => '千曲市'
            ],
            [
                'area_id' => 1,
                'name' => '坂城町'
            ],
            [
                'area_id' => 1,
                'name' => '小布施町'
            ],
            [
                'area_id' => 1,
                'name' => '高山村'
            ],
            [
                'area_id' => 1,
                'name' => '信濃町'
            ],
            [
                'area_id' => 1,
                'name' => '飯綱町'
            ],
            [
                'area_id' => 1,
                'name' => '小川村'
            ],
            [
                'area_id' => 2,
                'name' => '上松町'
            ],
            [
                'area_id' => 2,
                'name' => '南木曽町'
            ],
            [
                'area_id' => 2,
                'name' => '木曽町'
            ],
            [
                'area_id' => 2,
                'name' => '木祖村'
            ],
            [
                'area_id' => 2,
                'name' => '王滝村'
            ],
            [
                'area_id' => 2,
                'name' => '大桑村'
            ],
            [
                'area_id' => 2,
                'name' => '松本市'
            ],
            [
                'area_id' => 2,
                'name' => '塩尻市'
            ],
            [
                'area_id' => 2,
                'name' => '安曇野市'
            ],
            [
                'area_id' => 2,
                'name' => '麻績村'
            ],
            [
                'area_id' => 2,
                'name' => '生坂村'
            ],
            [
                'area_id' => 2,
                'name' => '山形村'
            ],
            [
                'area_id' => 2,
                'name' => '朝日村'
            ],
            [
                'area_id' => 2,
                'name' => '筑北村'
            ],
            [
                'area_id' => 2,
                'name' => '大町市'
            ],
            [
                'area_id' => 2,
                'name' => '池田町'
            ],
            [
                'area_id' => 2,
                'name' => '松川村'
            ],
            [
                'area_id' => 2,
                'name' => '白馬村'
            ],
            [
                'area_id' => 2,
                'name' => '小谷村'
            ],
            [
                'area_id' => 3,
                'name' => '小諸市'
            ],
            [
                'area_id' => 3,
                'name' => '佐久市'
            ],
            [
                'area_id' => 3,
                'name' => '小海町'
            ],
            [
                'area_id' => 3,
                'name' => '佐久穂町'
            ],
            [
                'area_id' => 3,
                'name' => '川上村'
            ],
            [
                'area_id' => 3,
                'name' => '南牧村'
            ],
            [
                'area_id' => 3,
                'name' => '南相木村'
            ],
            [
                'area_id' => 3,
                'name' => '北相木村'
            ],
            [
                'area_id' => 3,
                'name' => '軽井沢町'
            ],
            [
                'area_id' => 3,
                'name' => '御代田町'
            ],
            [
                'area_id' => 3,
                'name' => '立科町'
            ],
            [
                'area_id' => 3,
                'name' => '上田市'
            ],
            [
                'area_id' => 3,
                'name' => '東御市'
            ],
            [
                'area_id' => 3,
                'name' => '長和町'
            ],
            [
                'area_id' => 3,
                'name' => '青木村'
            ],
            [
                'area_id' => 4,
                'name' => '岡谷市'
            ],
            [
                'area_id' => 4,
                'name' => '諏訪市'
            ],
            [
                'area_id' => 4,
                'name' => '茅野市'
            ],
            [
                'area_id' => 4,
                'name' => '下諏訪町'
            ],
            [
                'area_id' => 4,
                'name' => '富士見町'
            ],
            [
                'area_id' => 4,
                'name' => '原村'
            ],
            [
                'area_id' => 4,
                'name' => '伊那市'
            ],
            [
                'area_id' => 4,
                'name' => '駒ヶ根市'
            ],
            [
                'area_id' => 4,
                'name' => '辰野町'
            ],
            [
                'area_id' => 4,
                'name' => '箕輪町'
            ],
            [
                'area_id' => 4,
                'name' => '飯島町'
            ],
            [
                'area_id' => 4,
                'name' => '南箕輪村'
            ],
            [
                'area_id' => 4,
                'name' => '中川村'
            ],
            [
                'area_id' => 4,
                'name' => '宮田村'
            ],
            [
                'area_id' => 4,
                'name' => '飯田市'
            ],
            [
                'area_id' => 4,
                'name' => '松川町'
            ],
            [
                'area_id' => 4,
                'name' => '高森町'
            ],
            [
                'area_id' => 4,
                'name' => '阿南町'
            ],
            [
                'area_id' => 4,
                'name' => '阿智村'
            ],
            [
                'area_id' => 4,
                'name' => '平谷村'
            ],
            [
                'area_id' => 4,
                'name' => '根羽村'
            ],
            [
                'area_id' => 4,
                'name' => '下條村'
            ],
            [
                'area_id' => 4,
                'name' => '売木村'
            ],
            [
                'area_id' => 4,
                'name' => '天龍村'
            ],
            [
                'area_id' => 4,
                'name' => '泰阜村'
            ],
            [
                'area_id' => 4,
                'name' => '喬木村'
            ],
            [
                'area_id' => 4,
                'name' => '豊丘村'
            ],
            [
                'area_id' => 4,
                'name' => '大鹿村'
            ],
        ];

        $data = [];
        foreach ($cities as $city) {
            $data[] = [
                'area_id' => $city['area_id'],
                'name' => $city['name'],
                'created_at' => Carbon::now(),
                'created_by' => 'seeder',
                'updated_at' => Carbon::now(),
                'updated_by' => 'seeder',
            ];
        }

        DB::table('cities')->insert($data);
    }
}
