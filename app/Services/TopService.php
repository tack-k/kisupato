<?php

namespace App\Services;

use App\Consts\CommonConst;

class TopService
{
    /**
     * 専門人材の地域と市町村を表示可能な形に整形
     * @param null $areas
     * @param null $areaAndCities
     * @return array
     */
    public function formatAreaData($areas = null, $areaAndCities = null): array
    {
        foreach ($areas as $area) {
            foreach ($areaAndCities as $areaAndCity) {
                if ($area->id === $areaAndCity->area_id)
                    $area->cities[] = [
                        'name' => $areaAndCity->city_name,
                        'count' => $areaAndCity->city_count,
                    ];
            }
        }

        $data = [];
        foreach ($areas as $area) {
            switch ($area->id) {
                case CommonConst::NORTH:
                    $data['north'] = $area;
                    break;
                case CommonConst::MIDDLE:
                    $data['middle'] = $area;
                    break;
                case CommonConst::EAST:
                    $data['east'] = $area;
                    break;
                case CommonConst::SOUTH:
                    $data['south'] = $area;
                    break;
            }
        }

        return $data;
    }
}
