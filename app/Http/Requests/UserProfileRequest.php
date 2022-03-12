<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserProfileRequest extends FormRequest {
    public function rules(): array
    {
        return [
            'nickname' => ['required', 'string', 'max:10', Rule::unique('user_profiles')->ignore(Auth::id(), 'nickname')],
            'profile_image.*' => ['file', 'image', 'max:5000'],
            'self_introduction' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return [
            'nickname' => 'ニックネーム',
            'profile_image.*' => 'プロフィール画像',
            'self_introduction' => '自己紹介',
        ];
    }
}
