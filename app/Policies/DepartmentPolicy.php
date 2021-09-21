<?php

namespace App\Policies;

use App\Consts\AuthorityConst;
use App\Models\Admins\Admin;
use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    /**
     * 共通ポリシー
     * @var commonPolicy
     */
    private $_commonPolicy;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_commonPolicy = new commonPolicy();
    }

    /**
     * 部署を作成できる権限設定
     * @param Admin $admin
     * @return bool
     */
    public function create(Admin $admin) {
        return $this->_commonPolicy->_allManagement($admin);
    }


    public function update(Admin $admin) {
        return $this->_commonPolicy->_allManagement($admin);
    }

    /**
     * 部署を削除できる権限設定
     * @param Admin $admin
     * @return bool
     */
    public function delete(Admin $admin)
    {
        return $this->_commonPolicy->_allManagement($admin);
    }


}
