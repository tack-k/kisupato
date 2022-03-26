<?php

namespace App\Services;

use Carbon\Carbon;

class ChatroomService {

    protected $_commonServie;

    public function __construct() {
        $this->_commonServie = new CommonService();
    }

    public function formatChatroomData($chatrooms)
    {
        foreach ($chatrooms as $key => $chatroom) {
            $chatroom['c_created_at'] = $this->_commonServie->formatDate($chatroom['c_created_at']);
            if(isset($chatroom['request_finished_at'])) {
                $chatroom['request_finished_at'] = $this->_commonServie->formatDate($chatroom['request_finished_at']);
            }

            $this->addChatroomStatusName($chatroom);

            $sort[$key] = $chatroom['m_created_at'];

        }

        $chatroomsAry = $chatrooms->toArray();

        array_multisort($sort, SORT_DESC, $chatroomsAry);

        return $chatroomsAry;
    }

    public function addChatroomStatusName($chatroom) {
        switch ($chatroom['consultation_status']) {
            case '0':
                $chatroom['consultation_status_name'] = '相談中';
                break;
            case '1':
                $chatroom['consultation_status_name'] = '相談完了';
                break;
            case '2':
                $chatroom['consultation_status_name'] = '相談キャンセル';
                break;
        }

        switch ($chatroom['request_status']) {
            case '0':
                $chatroom['request_status_name'] = '依頼検討中';
                break;
            case '1':
                $chatroom['request_status_name'] = '依頼中';
                break;
            case '2':
                $chatroom['request_status_name'] = '取引完了';
                break;
            case '3':
                $chatroom['request_status_name'] = '依頼キャンセル';
                break;
        }
    }

}
