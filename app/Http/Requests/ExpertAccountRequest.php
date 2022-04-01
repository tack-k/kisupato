<?php

namespace App\Http\Requests;

use App\Rules\KanaRule;
use App\Rules\PostalCodeRule;
use App\Rules\TelRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ExpertAccountRequest extends FormRequest {
    public function rules(): array {
        $data = $this->all();

        $validation = [
            'last_name' => 'required|string|max:20',
            'first_name' => 'required|string|max:20',
            'first_name_kana' => ['required', 'string', 'max:20', new KanaRule()],
            'last_name_kana' => ['required', 'string', 'max:20', new KanaRule()],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('experts')->ignore(Auth::guard('expert')->id())],
            'tel' => ['required', new TelRule()],
            'postal_code' => ['required', new PostalCodeRule()],
            'region' => 'required|string|max:10',
            'city' => 'required|string|max:10',
            'street' => 'required|string|max:20',
            'building' => 'nullable|string|max:30',
            'gender' => 'required|integer|numeric|digits_between:0,2',
            'birthday' => 'required|date|before_or_equal:today',
        ];

        $passwordValidation = [
            'current_password' => ['required', 'current_password:expert', Password::defaults()],
            'password' => ['required', 'confirmed', 'different:current_password', Password::defaults()],
        ];

        if ($data['is_password_change']) {
            return array_merge($validation, $passwordValidation);
        } else {
            return $validation;
        }
    }

    public function messages()
    {
        return [
            'birthday.before_or_equal' => ':attributeには本日以降の日付を入力してください。',
        ];
    }

    public function authorize(): bool {
        return true;
    }


    public function attributes()
    {
        return [
            'password' => '新しいパスワード'
        ];
    }
}
