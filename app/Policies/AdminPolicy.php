<?php

namespace App\Policies;

use App\Models\Admins\Admin;
use App\Consts\AuthorityConst;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admins\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $admin)
    {
        return $admin->authority_id === AuthorityConst::ALL_MANAGEMENT;
    }


    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $admin)
    {
        return $admin->authority_id === AuthorityConst::ALL_MANAGEMENT;
    }


}
