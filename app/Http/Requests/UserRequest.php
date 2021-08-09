<?php

namespace App\Http\Requests;

use App\Rules\KanaRule;
use App\Rules\PostalCodeRule;
use App\Rules\TelRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
            'last_name' => 'required|string|max:20',
            'first_name' => 'required|string|max:20',
            'first_name_kana' => ['required','string','max:20',new KanaRule()],
            'last_name_kana' => ['required', 'string', 'max:20', new KanaRule()],
            'email' => 'required|string|email|max:255|unique:users',
            'tel' => ['required',  new TelRule()],
            'postal_code' => ['required',  new PostalCodeRule()],
            'region' => 'required|string|max:10',
            'city' => 'required|string|max:10',
            'street' => 'required|string|max:20',
            'building' => 'nullable|string|max:30',
            'gender' => 'required|integer|numeric|digits_between:0,2',
            'birthday' => 'required|date|before_or_equal:today',
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }


}
