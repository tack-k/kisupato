<?php


namespace App\Consts;


class SideBarConst
{
    public const USER_MANAGEMENT = 'ユーザー管理';
    public const DATA_MANAGEMENT = 'データ管理';
    public const UTILIZATION_STATUS = 'サイト活用状況';
    public const CONTACT_MANAGEMENT = '問い合わせ管理';
    public const NOTIFICATION_FUNCTION = 'お知らせ機能';

    public const ADMIN = '職員';
    public const USER = 'ユーザー';
    public const EXPERT = '専門人材';
    public const USER_MANAGEMENT_LISTS = [
        'admin' => self::ADMIN,
        'user' => self::USER,
        'expert' => self::EXPERT,
    ];

    public const EXPERT_POSITION = '専門人材肩書';
    public const EXPERT_TAG = '専門人材タグ';
    public const DEPARTMENT = '部署';
    public const AUTHORITY = '権限';
    public const USER_CONTACT_TITLE = 'ユーザー問い合わせ項目';
    public const EXPERT_CONTACT_TITLE = '専門人材問い合わせ項目';
    public const DATA_MANAGEMENT_LISTS = [
      'expert_position' => self::EXPERT_POSITION,
      'expert_tag' => self::EXPERT_TAG,
      'department' => self::DEPARTMENT,
      'authority' => self::AUTHORITY,
      'user_contact_title' => self::USER_CONTACT_TITLE,
      'expert_contact_title' => self::EXPERT_CONTACT_TITLE,
    ];

    public const CONTACT_MANAGEMENT_LISTS = [
        'user' => self::USER,
        'expert' => self::EXPERT,
    ];

    public const MAIL_MAGAZINE = 'メルマガ';
    public const INFORMATION_SITE = 'サイトからのお知らせ';
    public const NOTIFICATION_FUNCTION_LISTS = [
        'mail_magazine' => self::MAIL_MAGAZINE,
        'information_site' => self::INFORMATION_SITE,
    ];

    public const SIDEBAR_LISTS = [
        'user_management' => [
            'id' => 0,
            'title' => self::USER_MANAGEMENT,
            'subtitle' => self::USER_MANAGEMENT_LISTS,
        ],
        'data_management' => [
            'id' => 1,
            'title' => self::DATA_MANAGEMENT,
            'subtitle' => self::DATA_MANAGEMENT_LISTS,
        ],
        'utilization_status' => [
            'id' => 2,
            'title' => self::UTILIZATION_STATUS,
            'subtitle' => null,
        ],
        'contact_management' => [
            'id' => 3,
            'title' => self::CONTACT_MANAGEMENT,
            'subtitle' => self::CONTACT_MANAGEMENT_LISTS
        ],
        'notification_function' => [
            'id' => 4,
            'title' => self::NOTIFICATION_FUNCTION,
            'subtitle' => self::NOTIFICATION_FUNCTION_LISTS,
        ],
    ];
}
