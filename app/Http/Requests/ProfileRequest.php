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
            'nickname' => ['required', 'string', 'max:10', Rule::unique('profiles')->ignore($this->expeert)],
            'image' => ['required', 'file', 'image'],
            'self_introduction' => ['required','string','max:500'],
            'activity_title' => 'required|string|max:30',
            'activity_image.*' => ['required', 'file', 'image'],
            'activity_content' => 'required|string|max:500',
            'skills' => ['required', 'array'],
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
            'activity_image' => '活動写真',
            'activity_content' => '活動内容',
            'skills' => '提供スキル',
        ];
    }
}
