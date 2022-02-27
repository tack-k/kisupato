<?php

namespace App\Http\Requests;

use App\Rules\TelRule;
use Illuminate\Foundation\Http\FormRequest;

class UserContactRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'tel' => ['required', new TelRule(),'string'],
            'user_contact_title_id' => 'required|exists:user_contact_titles,id',
            'content' => 'required|string',
        ];
    }

    public function authorize(): bool {
        return true;
    }

    public function attributes() {
        return [
          'user_contact_title_id' => '項目',
          'content' => '内容',
          'name' => '氏名',
          'email' => 'メールアドレス',
          'tel' => '電話番号',
        ];
    }
}
