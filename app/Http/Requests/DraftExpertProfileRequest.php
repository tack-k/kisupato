<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DraftExpertProfileRequest extends FormRequest
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
            'status' => ['nullable', 'integer', 'numeric'],
            'nickname' => ['nullable', 'string', 'max:10', Rule::unique('expert_profiles')->ignore(Auth::guard('expert')->id(), 'expert_id')],
            'profile_image.*' => ['file', 'image', 'max:5000'],
            'self_introduction' => ['nullable', 'string', 'max:500'],
            'activity_title' => 'nullable|string|max:30',
            'activity_content' => 'nullable|string|max:500',
            'activity_images.*' => ['nullable', 'file', 'image', 'max:5000'],
            'skills.*.skill_title' => ['nullable', 'max:30'],
            'skills.*.skill_content' => ['nullable', 'max:300'],
        ];
    }

    public function attributes()
    {
        return [
            'status' => 'ステータス',
            'nickname' => 'ニックネーム',
            'profile_image.*' => 'プロフィール画像',
            'self_introduction' => '自己紹介',
            'activity_title' => '活動タイトル',
            'activity_images' => '活動写真',
            'activity_images.*' => '活動写真',
            'activity_content' => '活動内容',
            'skills.*.skill_title' => '提供スキルタイトル',
            'skills.*.skill_content' => '提供スキル内容',
        ];
    }
}
