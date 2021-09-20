<?php


namespace App\Consts;


class MessageConst
{
    //定形文字
    public const ADMIN = '職員';
    public const USER = 'ユーザー';
    public const DEPARTMENT = '部署';
    public const AUTHORITY = '権限';

    public const INIT_PASSWORD = '初期パスワード';
    public const ADMIN_BY = 'admin:';
    public const USER_BY = 'user:';


    //エラーメッセージ
    public const E_00001 = 'を作成できませんでした';
    public const E_00002 = 'を変更できませんでした';
    public const E_00003 = 'を削除できませんでした';
    public const E_01001 = '作成権限がありません';
    public const E_01002 = '変更権限がありません';
    public const E_01003 = '削除権限がありません';



    //インフォメーションメッセージ
    public const I_00001 = "を作成しました";
    public const I_00002 = "を変更しました";
    public const I_00003 = "を削除しました";
    public const I_01001 = "ご登録いただいたメールアドレスにアカウント発行のメールを送信しました";
}
