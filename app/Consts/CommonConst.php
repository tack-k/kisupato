<?php

namespace App\Consts;

class CommonConst {
    //専門人材活動写真の保存パス
    public const ACTIVITY_PATH = 'activity_images/';

    //専門人材プロフィール画像の保存パス
    public const PROFILE_PATH = 'profile_images/';

    //ユーザープロフィール画像の保存パス
    public const USER_PROFILE_PATH = 'user_profile_images/';

    //下書き活動写真の保存パス
    public const DRAFT_ACTIVITY_PATH = 'draft_activity_images/';

    //下書きプロフィール画像の保存パス
    public const DRAFT_PROFILE_PATH = 'draft_profile_images/';
    //地域idの定数
    public const NORTH = 1;
    public const MIDDLE = 2;
    public const EAST = 3;
    public const SOUTH = 4;

    //seeder設定
    public const  EXPERT_COUNT = 100;
    public const  ORIGINAL_EXPERT_COUNT = 1;

    public const  USER_COUNT = 50;
    public const  ORIGINAL_USER_COUNT = 1;

    //プロフィールカードの活動内容の文字制限数
    public const MAX_ACTIVITY_CONTENT_COUNT = 40;

    //プロフィールカードの活動タイトルの文字制限数
    public const MAX_ACTIVITY_TITLE_COUNT = 13;

    //依頼リクエストの状態
    public const REQUEST_EXAMINATION = '0'; //検討中
    public const REQUEST = '1'; //依頼中
    public const REQUEST_FINISHED = '2';
    public const REQUEST_CANCELED = '3'; //キャンセル

    //相談状況
    public const CONSULTATION = '0'; //相談中
    public const CONSULTATION_FINISHED = '1';
    public const CONSULTATION_CANCELED = '2';

    //年月日の表示形式
    public const DATE_FORMAT = 'Y/m/d';
}
