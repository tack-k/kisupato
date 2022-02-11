<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Consts\CommonConst;

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
                'area_id' => CommonConst::NORTH,
                'name' => '中野市',
                'latitude' => 36.74,
                'longitude' => 138.36,
            ],
            [
                'area_id' => CommonConst::NORTH,
                'name' => '飯山市',
                'latitude' => 36.85,
                'longitude' => 138.36,
            ],
            [
                'area_id' => CommonConst::NORTH,
                'name' => '山ノ内町',
                'latitude' => 36.74,
                'longitude' => 138.41,
            ],
            [
                'area_id' => CommonConst::NORTH,
                'name' => '木島平村',
                'latitude' => 36.85,
                'longitude' => 138.40,
            ],
            [
                'area_id' => CommonConst::NORTH,
                'name' => '野沢温泉村',
                'latitude' => 36.92,
                'longitude' => 138.44,
            ],
            [
                'area_id' => CommonConst::NORTH,
                'name' => '栄村',
                'latitude' => 36.98,
                'longitude' => 138.57,
            ],
            [
                'area_id' => CommonConst::NORTH,
                'name' => '長野市',
                'latitude' => 36.64,
                'longitude' => 138.19,
            ],
            [
                'area_id' => CommonConst::NORTH,
                'name' => '須坂市',
                'latitude' => 36.65,
                'longitude' => 138.30,
            ],
            [
                'area_id' => CommonConst::NORTH,
                'name' => '千曲市',
                'latitude' => 36.53,
                'longitude' => 138.12,
            ],
            [
                'area_id' => CommonConst::NORTH,
                'name' => '坂城町',
                'latitude' => 36.46,
                'longitude' => 138.18,
            ],
            [
                'area_id' => CommonConst::NORTH,
                'name' => '小布施町',
                'latitude' => 36.69,
                'longitude' => 138.31,
            ],
            [
                'area_id' => CommonConst::NORTH,
                'name' => '高山村',
                'latitude' => 36.67,
                'longitude' => 138.36,

            ],
            [
                'area_id' => CommonConst::NORTH,
                'name' => '信濃町',
                'latitude' => 36.80,
                'longitude' => 138.2,

            ],
            [
                'area_id' => CommonConst::NORTH,
                'name' => '飯綱町',
                'latitude' => 36.76,
                'longitude' => 138.25,

            ],
            [
                'area_id' => CommonConst::NORTH,
                'name' => '小川村',
                'latitude' => 36.61,
                'longitude' => 137.97,

            ],
            [
                'area_id' => CommonConst::MIDDLE,
                'name' => '上松町',
                'latitude' => 35.78,
                'longitude' => 137.69,

            ],
            [
                'area_id' => CommonConst::MIDDLE,
                'name' => '南木曽町',
                'latitude' => 35.60,
                'longitude' => 137.60,

            ],
            [
                'area_id' => CommonConst::MIDDLE,
                'name' => '木曽町',
                'latitude' => 35.84,
                'longitude' => 137.69,
            ],
            [
                'area_id' => CommonConst::MIDDLE,
                'name' => '木祖村',
                'latitude' => 35.93,
                'longitude' => 137.78,
            ],
            [
                'area_id' => CommonConst::MIDDLE,
                'name' => '王滝村',
                'latitude' => 35.80,
                'longitude' => 137.55,
            ],
            [
                'area_id' => CommonConst::MIDDLE,
                'name' => '大桑村',
                'latitude' => 35.68,
                'longitude' => 137.66,
            ],
            [
                'area_id' => CommonConst::MIDDLE,
                'name' => '松本市',
                'latitude' => 36.23,
                'longitude' => 137.97,
            ],
            [
                'area_id' => CommonConst::MIDDLE,
                'name' => '塩尻市',
                'latitude' => 36.11,
                'longitude' => 137.95,
            ],
            [
                'area_id' => CommonConst::MIDDLE,
                'name' => '安曇野市',
                'latitude' => 36.30,
                'longitude' => 137.90,
            ],
            [
                'area_id' => CommonConst::MIDDLE,
                'name' => '麻績村',
                'latitude' => 36.45,
                'longitude' => 138.04,
            ],
            [
                'area_id' => CommonConst::MIDDLE,
                'name' => '生坂村',
                'latitude' => 36.42,
                'longitude' => 137.92,
            ],
            [
                'area_id' => CommonConst::MIDDLE,
                'name' => '山形村',
                'latitude' => 36.16,
                'longitude' => 137.87,
            ],
            [
                'area_id' => CommonConst::MIDDLE,
                'name' => '朝日村',
                'latitude' => 36.12,
                'longitude' => 137.86,
            ],
            [
                'area_id' => CommonConst::MIDDLE,
                'name' => '筑北村',
                'latitude' => 36.40,
                'longitude' => 138.01,
            ],
            [
                'area_id' => CommonConst::MIDDLE,
                'name' => '大町市',
                'latitude' => 36.5,
                'longitude' => 137.85,
            ],
            [
                'area_id' => CommonConst::MIDDLE,
                'name' => '池田町',
                'latitude' => 36.42,
                'longitude' => 137.87,
            ],
            [
                'area_id' => CommonConst::MIDDLE,
                'name' => '松川村',
                'latitude' => 36.42,
                'longitude' => 137.85,
            ],
            [
                'area_id' => CommonConst::MIDDLE,
                'name' => '白馬村',
                'latitude' => 36.69,
                'longitude' => 137.86,
            ],
            [
                'area_id' => CommonConst::MIDDLE,
                'name' => '小谷村',
                'latitude' => 36.77,
                'longitude' => 137.90,
            ],
            [
                'area_id' => CommonConst::EAST,
                'name' => '小諸市',
                'latitude' => 36.32,
                'longitude' => 138.42,
            ],
            [
                'area_id' => CommonConst::EAST,
                'name' => '佐久市',
                'latitude' => 36.24,
                'longitude' => 138.47,
            ],
            [
                'area_id' => CommonConst::EAST,
                'name' => '小海町',
                'latitude' => 36.09,
                'longitude' => 138.48,
            ],
            [
                'area_id' => CommonConst::EAST,
                'name' => '佐久穂町',
                'latitude' => 36.16,
                'longitude' => 138.48,
            ],
            [
                'area_id' => CommonConst::EAST,
                'name' => '川上村',
                'latitude' => 35.97,
                'longitude' => 138.57,
            ],
            [
                'area_id' => CommonConst::EAST,
                'name' => '南牧村',
                'latitude' => 36.02,
                'longitude' => 138.49,
            ],
            [
                'area_id' => CommonConst::EAST,
                'name' => '南相木村',
                'latitude' => 36.03,
                'longitude' => 138.54,
            ],
            [
                'area_id' => CommonConst::EAST,
                'name' => '北相木村',
                'latitude' => 36.05,
                'longitude' => 138.55,
            ],
            [
                'area_id' => CommonConst::EAST,
                'name' => '軽井沢町',
                'latitude' => 36.34,
                'longitude' => 138.59,
            ],
            [
                'area_id' => CommonConst::EAST,
                'name' => '御代田町',
                'latitude' => 36.32,
                'longitude' => 138.50,
            ],
            [
                'area_id' => CommonConst::EAST,
                'name' => '立科町',
                'latitude' => 36.27,
                'longitude' => 138.31,
            ],
            [
                'area_id' => CommonConst::EAST,
                'name' => '上田市',
                'latitude' => 36.40,
                'longitude' => 138.24,
            ],
            [
                'area_id' => CommonConst::EAST,
                'name' => '東御市',
                'latitude' => 36.35,
                'longitude' => 138.33,
            ],
            [
                'area_id' => CommonConst::EAST,
                'name' => '長和町',
                'latitude' => 36.25,
                'longitude' => 138.26,
            ],
            [
                'area_id' => CommonConst::EAST,
                'name' => '青木村',
                'latitude' => 36.37,
                'longitude' => 138.12,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '岡谷市',
                'latitude' => 36.06,
                'longitude' => 138.04,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '諏訪市',
                'latitude' => 36.03,
                'longitude' => 138.11,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '茅野市',
                'latitude' => 35.99,
                'longitude' => 138.15,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '下諏訪町',
                'latitude' => 36.06,
                'longitude' => 138.08,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '富士見町',
                'latitude' => 35.91,
                'longitude' => 138.24,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '原村',
                'latitude' => 35.96,
                'longitude' => 138.21,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '伊那市',
                'latitude' => 35.82,
                'longitude' => 137.95,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '駒ヶ根市',
                'latitude' => 35.72,
                'longitude' => 137.93,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '辰野町',
                'latitude' => 35.98,
                'longitude' => 137.98,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '箕輪町',
                'latitude' => 35.91,
                'longitude' => 137.98,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '飯島町',
                'latitude' => 35.67,
                'longitude' => 137.91,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '南箕輪村',
                'latitude' => 35.87,
                'longitude' => 137.97,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '中川村',
                'latitude' => 35.63,
                'longitude' => 137.94,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '宮田村',
                'latitude' => 35.76,
                'longitude' => 137.94,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '飯田市',
                'latitude' => 35.51,
                'longitude' => 137.82,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '松川町',
                'latitude' => 35.59,
                'longitude' => 137.90,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '高森町',
                'latitude' => 35.55,
                'longitude' => 137.87,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '阿南町',
                'latitude' => 35.32,
                'longitude' => 137.81,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '阿智村',
                'latitude' => 35.44,
                'longitude' => 137.74,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '平谷村',
                'latitude' => 35.32,
                'longitude' => 137.63,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '根羽村',
                'latitude' => 35.25,
                'longitude' => 137.58,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '下條村',
                'latitude' => 35.39,
                'longitude' => 137.78,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '売木村',
                'latitude' => 35.27,
                'longitude' => 137.71,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '天龍村',
                'latitude' => 35.27,
                'longitude' => 137.85,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '泰阜村',
                'latitude' => 35.37,
                'longitude' => 137.84,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '喬木村',
                'latitude' => 35.51,
                'longitude' => 137.87,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '豊丘村',
                'latitude' => 35.55,
                'longitude' => 137.89,
            ],
            [
                'area_id' => CommonConst::SOUTH,
                'name' => '大鹿村',
                'latitude' => 35.57,
                'longitude' => 138.03,
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
                'latitude' => $city['latitude'],
                'longitude' => $city['longitude'],
            ];
        }

        DB::table('cities')->insert($data);
    }
}
