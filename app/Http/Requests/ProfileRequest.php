<?php

namespace App\Http\Requests;

use App\Rules\KanaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
            'nickname' => ['required', 'string', 'max:10', Rule::unique('profiles')->ignore($this->expert)],
            'image' => ['required', 'file', 'image', 'max:5000'],
            'self_introduction' => ['required','string','max:500'],
            'activity_title' => 'required|string|max:30',
            'activity_content' => 'required|string|max:500',
            'activity_images' => ['required'],
            'activity_images.*' => ['required', 'file', 'image', 'max:5000'],
            'skills.*.skill_title' => ['required', 'max:30'],
            'skills.*.skill_content' => ['required', 'max:300'],
        ];
    }

    public function attributes()
    {
        return [
            'status' => 'ステータス',
            'nickname' => 'ニックネーム',
            'image' => 'プロフィール画像',
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
