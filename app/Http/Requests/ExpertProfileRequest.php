<?php

namespace App\Http\Requests;

use App\Consts\ExpertConst;
use App\Models\Experts\ExpertProfile;
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

        $expert_id = Auth::guard('expert')->id();
        $profile = ExpertProfile::find($expert_id);

        if (isset($profile) && $profile->status === ExpertConst::PUBLIC) {
            return [
                'nickname' => ['required', 'string', 'max:10', Rule::unique('expert_profiles')->ignore(Auth::guard('expert')->id(), 'expert_id')],
                'self_introduction' => ['required', 'string', 'max:500'],
                'activity_title' => 'required|string|max:30',
                'activity_content' => 'required|string|max:500',
                'activity_images.*' => ['required', 'file', 'image', 'max:5000'],
                'activity_base' => ['required', 'integer', 'numeric', 'exists:cities,id'],
                'skills.*.skill_title' => ['required', 'max:30'],
                'skills.*.skill_content' => ['required', 'max:300'],
                'tag.*' => ['required', 'integer', 'numeric', 'exists:tags,id'],
                'position' => ['required', 'integer', 'numeric', 'exists:positions,id'],
            ];
        } else {
            return [
                'nickname' => ['nullable', 'string', 'max:10', Rule::unique('expert_profiles')->ignore(Auth::guard('expert')->id(), 'expert_id')],
                'profile_image.*' => ['file', 'image', 'max:5000'],
                'self_introduction' => ['nullable', 'string', 'max:500'],
                'activity_title' => 'nullable|string|max:30',
                'activity_content' => 'nullable|string|max:500',
                'activity_images.*' => ['nullable', 'file', 'image', 'max:5000'],
                'activity_base' => ['nullable', 'integer', 'numeric', 'exists:cities,id'],
                'skills.*.skill_title' => ['nullable', 'max:30'],
                'skills.*.skill_content' => ['nullable', 'max:300'],
                'tag.*' => ['nullable', 'integer', 'numeric', 'exists:tags,id'],
                'position' => ['nullable', 'integer', 'numeric', 'exists:positions,id'],
            ];
        }

    }

    public function withValidator($validator)
    {

        $validator->after(function ($validator) {

            $expert_id = Auth::guard('expert')->id();
            $profile = ExpertProfile::where('expert_id', $expert_id)->first();

            if (isset($profile) && $profile->status === ExpertConst::PUBLIC) {
                if (!$this->hasAny(['profile_image', 'saved_profile_image'])) {
                    $validator->errors()->add('profile_image', 'プロフィール画像は必ず設定してください。');
                }

                if (!$this->hasAny(['activity_images', 'saved_activity_images'])) {
                    $validator->errors()->add('activity_images', '活動写真は必ず設定してください。');
                }

                if (!$this->hasAny(['tag'])) {
                    $validator->errors()->add('tag', 'タグは必ず設定してください。');
                }
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
            'activity_base' => '活動拠点',
            'skills.*.skill_title' => '提供スキルタイトル',
            'skills.*.skill_content' => '提供スキル内容',
            'tag.*' => 'タグ',
            'position' => '肩書',
        ];
    }
}
