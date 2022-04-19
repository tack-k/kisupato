<?php


namespace App\Consts;


class AdminConst
{
    //パスワード初期化の状態
    public const NOT_INITIALIZED = 0;
    public const INITIALIZED = 1;

    //サイトからのお知らせのステータス
    public const INFORMATION_SITE_PUBLIC = '0';
    public const INFORMATION_SITE_PRIVATE = '1';
    public const INFORMATION_SITE_RESERVED = '2';

}
