<?php

namespace App\Http\Requests;

use App\Rules\KanaRule;
use App\Rules\PostalCodeRule;
use App\Rules\TelRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserAccountRequest extends FormRequest {
    public function rules(): array
    {
        return [
            'last_name' => 'required|string|max:20',
            'first_name' => 'required|string|max:20',
            'first_name_kana' => ['required','string','max:20',new KanaRule()],
            'last_name_kana' => ['required', 'string', 'max:20', new KanaRule()],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            'tel' => ['required',  new TelRule()],
            'postal_code' => ['required',  new PostalCodeRule()],
            'region' => 'required|string|max:10',
            'city' => 'required|string|max:10',
            'street' => 'required|string|max:20',
            'building' => 'nullable|string|max:30',
            'gender' => 'required|integer|numeric|digits_between:0,2',
            'birthday' => 'required|date|before_or_equal:today',
            'current_password' => ['required', 'current_password:user', Password::defaults()],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function messages()
    {
        return [
            'birthday.before_or_equal' => ':attributeには本日以降の日付を入力してください。',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
