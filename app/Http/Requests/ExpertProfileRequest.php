<?php

namespace App\Http\Requests;

use App\Rules\KanaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ExpertProfileRequest extends FormRequest
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
            'status' => ['required', 'integer', 'numeric'],
            'nickname' => ['required', 'string', 'max:10', Rule::unique('expert_profiles')->ignore(Auth::guard('expert')->id(), 'expert_id')],
            'profile_image.*' => ['file', 'image', 'max:5000'],
            'self_introduction' => ['required','string','max:500'],
            'activity_title' => 'required|string|max:30',
            'activity_content' => 'required|string|max:500',
            'activity_images.*' => ['required', 'file', 'image', 'max:5000'],
            'skills.*.skill_title' => ['required', 'max:30'],
            'skills.*.skill_content' => ['required', 'max:300'],
        ];
    }

    public function withValidator($validator)
    {

        $validator->after(function ($validator) {

            if (!$this->hasAny(['profile_image', 'saved_profile_image'])) {
                $validator->errors()->add('profile_image', 'プロフィール画像は必ず設定してください。');
            }

            if (!$this->hasAny(['activity_images', 'saved_activity_images'])) {
                $validator->errors()->add('activity_images', '活動写真は必ず設定してください。');
            }
        });
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
