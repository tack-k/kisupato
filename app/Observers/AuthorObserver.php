<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Consts\MessageConst;

class AuthorObserver
{
    /**
     * データ作成時に作成者を保存
     * @param Model $model
     * @return void
     */
    public function creating(Model $model){
        $this->_makeCreatedBy($model);
    }

    /**
     * データ作成・更新時に更新者を保存
     * @param Model $model
     * @return void
     */
    public function saving(Model $model){
        $this->_makeCreatedBy($model);
    }

    /**
     * データ削除時に削除者を保存
     * @param Model $model
     * @return void
     */
    public function deleting(Model $model){
        $this->_makeCreatedBy($model);
    }

    public function _makeCreatedBy($model) {
        if(Auth::guard('user')->check()) {
            $model->created_by = MessageConst::USER_BY . Auth::guard('user')->id();
        } elseif (Auth::guard('admin')->check()) {
            $model->created_by = MessageConst::ADMIN_BY . Auth::guard('admin')->id();
        } elseif (Auth::guard('expert')->check()) {
            $model->created_by = MessageConst::EXPERT_BY . Auth::guard('expert')->id();
        }
    }
}
