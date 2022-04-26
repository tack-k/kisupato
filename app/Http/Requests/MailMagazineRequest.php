<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailMagazineRequest extends FormRequest {
    public function rules(): array {
        return [
            'title' => 'required|string|max:50',
            'description' => 'required|string',
            'status' => 'required|between:0,1',
            'reserved_at' => 'exclude_unless:status,0|required|after:now|date',
        ];
    }

    public function attributes()
    {
        return [
            'title' => '件名',
            'description' => '内容',
            'status' => 'ステータス',
            'reserved_at' => '予約日時',
        ];
    }

    protected function getValidatorInstance() {
        $validator = parent::getValidatorInstance();

        $validator->setValueNames([
            'status' => [
                '0' => '送信予約'
            ]
        ]);

        return $validator;
    }

    public function authorize(): bool {
        return true;
    }
}
