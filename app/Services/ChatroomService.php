<?php

namespace App\Services;

use Carbon\Carbon;

class ChatroomService {

    public function formatChatroomData($chatrooms) {
        foreach ($chatrooms as $key => $chatroom) {
            $data = new Carbon($chatroom['c_created_at']);
            $chatroom['c_created_at'] = $data->format('Y/m/d');
            $chatroom['consultation_status'] = $chatroom['consultation_status'] === '0' ? '相談中' : '完了';

            switch ($chatroom['request_status']) {
                case '0':
                    $chatroom['request_status'] = '検討中';
                    break;
                case '1':
                    $chatroom['request_status'] = '依頼中';
                    break;
                case '2':
                    $chatroom['request_status'] = '完了';
                    break;
                case '3':
                    $chatroom['request_status'] = '依頼なし';
                    break;
            }

            $sort[$key] = $chatroom['m_created_at'];

        }

        $chatroomsAry = $chatrooms->toArray();

        array_multisort($sort, SORT_DESC, $chatroomsAry);

        return $chatroomsAry;
    }

}
