<?php

namespace App\Http\Requests;

use App\Rules\KanaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
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
            'staff_number' => ['required', 'string', 'max:10', Rule::unique('admins')->ignore($this->admin)],
            'last_name_kana' => ['required', 'string', 'max:20', new KanaRule()],
            'first_name_kana' => ['required','string','max:20',new KanaRule()],
            'last_name' => 'required|string|max:20',
            'first_name' => 'required|string|max:20',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admins')->ignore($this->admin)],
            'department_id' => 'required|exists:departments,id|integer|numeric',
            'authority_id' => 'required|exists:authorities,id|integer|numeric',
        ];
    }
}
