<?php

namespace App\Http\Requests;

use App\Consts\CommonConst;
use Illuminate\Foundation\Http\FormRequest;
use function PHPUnit\Framework\isEmpty;

class MailMagazineRequest extends FormRequest {
    public function rules(): array {
        return [
            'send_user' => 'nullable|boolean',
            'send_expert' => 'nullable|boolean',
            'target_user' => 'exclude_unless:send_user,true|required|in:0,1',
            'target_expert' => 'exclude_unless:send_expert,true|required|in:0,1,2',
            'title' => 'required|string|max:50',
            'description' => 'required|string',
            'status' => 'required|between:0,1',
            'reserved_at' => 'exclude_unless:status,0|required|after:now|date',
        ];
    }

    public function attributes()
    {
        return [
            'send_user' => 'ユーザー宛先',
            'send_expert' => '専門人材宛先',
            'target_user' => 'ユーザーの送信設定',
            'target_expert' => '専門人材の送信設定',
            'title' => '件名',
            'description' => '内容',
            'status' => 'ステータス',
            'reserved_at' => '予約日時',
        ];
    }

    public function withValidator($validator) {
        $checked_tags = $this->input('checked_tags');
        $checked_positions = $this->input('checked_positions');
        $targetExpert = $this->input('target_expert');

        $validator->after(function ($validator) use ($checked_positions, $checked_tags, $targetExpert) {
           if($targetExpert === CommonConst::TARGET_SELECT && empty($checked_tags) && empty($checked_positions)) {
               $validator->errors()->add('destination', '選択送信を選択した場合は、必ず送信先を設定してください。');
           }
        });

        $sendUser = $this->input('send_user');
        $sendExpert = $this->input('send_expert');
        $validator->after(function ($validator) use ($sendUser, $sendExpert) {
           if(!$sendUser && !$sendExpert) {
               $validator->errors()->add('destination', '宛先は必ず選択してください');
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
