<?php

namespace App\Rules;

use App\Models\Admins\Admin;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\False_;

class AdminStatusRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($admin_ids)
    {
        $this->admin_ids = $admin_ids;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $login_id = Auth::guard('admin')->id();
        $admins = Admin::find($this->admin_ids);

        foreach ($admins as $admin) {
            if($login_id === $admin->id) {
                return false;
            }
    }
        return true;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '管理者自身のステータスは変更・削除できません。';
    }
}
