<?php

namespace App\Http\Requests;

use App\Consts\CommonConst;
use Illuminate\Foundation\Http\FormRequest;
use function PHPUnit\Framework\isEmpty;

class MailMagazineRequest extends FormRequest {
    public function rules(): array {
        return [
            'target' => 'required|between:0,1',
            'title' => 'required|string|max:50',
            'description' => 'required|string',
            'status' => 'required|between:0,1',
            'reserved_at' => 'exclude_unless:status,0|required|after:now|date',
        ];
    }

    public function attributes()
    {
        return [
            'target' => '宛先',
            'title' => '件名',
            'description' => '内容',
            'status' => 'ステータス',
            'reserved_at' => '予約日時',
        ];
    }

    public function withValidator($validator) {
        $checked_tags = $this->input('checked_tags');
        $checked_positions = $this->input('checked_positions');
        $target = $this->input('target');

        $validator->after(function ($validator) use ($checked_positions, $checked_tags, $target) {
           if($target === CommonConst::TARGET_SELECT && empty($checked_tags) && empty($checked_positions)) {
               $validator->errors()->add('destination', '送信先は必ず選択してください');
           }
        });
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
