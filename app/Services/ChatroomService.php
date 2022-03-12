<?php

namespace App\Services;

use Carbon\Carbon;

class ChatroomService {

    public function formatChatroomData($chatrooms)
    {
        foreach ($chatrooms as $key => $chatroom) {
            $data = new Carbon($chatroom['c_created_at']);
            $chatroom['c_created_at'] = $data->format('Y/m/d');

            switch ($chatroom['consultation_status']) {
                case '0':
                    $chatroom['consultation_status_name'] = '相談中';
                    break;
                case '1':
                    $chatroom['consultation_status_name'] = '完了';
                    break;
                case '2':
                    $chatroom['consultation_status_name'] = 'キャンセル';
                    break;
            }

            switch ($chatroom['request_status']) {
                case '0':
                    $chatroom['request_status_name'] = '検討中';
                    break;
                case '1':
                    $chatroom['request_status_name'] = '依頼中';
                    break;
                case '2':
                    $chatroom['request_status_name'] = '取引完了';
                    break;
                case '3':
                    $chatroom['request_status_name'] = 'キャンセル';
                    break;
            }

            $sort[$key] = $chatroom['m_created_at'];

        }

        $chatroomsAry = $chatrooms->toArray();

        array_multisort($sort, SORT_DESC, $chatroomsAry);

        return $chatroomsAry;
    }

}
