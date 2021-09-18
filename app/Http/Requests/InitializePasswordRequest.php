<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class InitializePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'current_password' => ['required', Password::defaults()],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function withValidator($validator) {
        $validator->after(function ($validator) {
            $currentPassword = $this->input('current_password');
            $currentSavedPassword = Auth::guard('admin')->user()->password;

            if(Hash::check($currentPassword, $currentSavedPassword)) {
                return true;
            } else {
                $validator->errors()->add('current_password_mismatch', '登録されたパスワードと現在のパスワードが一致していません。');
            }

        });

    }
}
