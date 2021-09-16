<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuthorObserver
{
    /**
     * データ作成時に作成者を保存
     * @param Model $model
     * @return void
     */
    public function creating(Model $model){
        if(Auth::guard('user')->check()) {
        $model->created_by = 'user:' . Auth::guard('user')->id();
        } elseif (Auth::guard('admin')->check()) {
        $model->created_by = 'admin:' . Auth::guard('admin')->id();
        }
    }

    /**
     * データ作成・更新時に更新者を保存
     * @param Model $model
     * @return void
     */
    public function saving(Model $model){
        if(Auth::guard('user')->check()) {
            $model->updated_by = 'user:' . Auth::guard('user')->id();
        } elseif (Auth::guard('admin')->check()) {
            $model->updated_by = 'admin:' . Auth::guard('admin')->id();
        }
    }

    /**
     * データ削除時に削除者を保存
     * @param Model $model
     * @return void
     */
    public function deleting(Model $model){
        if(Auth::guard('user')->check()) {
            $model->deleted_by = 'user:' . Auth::guard('user')->id();
        } elseif (Auth::guard('admin')->check()) {
            $model->deleted_by = 'admin:' . Auth::guard('admin')->id();
        }
    }
}
