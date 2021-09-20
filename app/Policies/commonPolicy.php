<?php

namespace App\Policies;

use App\Consts\AuthorityConst;
use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class commonPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 管理者の権限が全体管理ユーザーの場合
     *
     * @param $admin
     * @return bool
     */
    public function _allManagement($admin) {
        return $admin->authority_id === AuthorityConst::ALL_MANAGEMENT;
    }
}
