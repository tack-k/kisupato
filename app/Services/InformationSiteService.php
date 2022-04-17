<?php

namespace App\Services;

class InformationSiteService {

    public function formatInformationSiteStatus($status) {
        switch ($status) {
            case '0':
                return '公開中';
            case '1':
                return '非公開';
            case '2':
                return '予約投稿';
        }
    }
}
