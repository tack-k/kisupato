<?php

namespace App\Policies;

use App\Models\Admins\Admin;
use App\Consts\AuthorityConst;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
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
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admins\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $admin)
    {
        return $this->_commonPolicy->_allManagement($admin);
    }

    public function update(Admin $admin) {
        return $this->_commonPolicy->_allManagement($admin);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admins\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $admin)
    {
        return $this->_commonPolicy->_allManagement($admin);
    }


}
