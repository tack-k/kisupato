<?php

namespace App\Http\Requests;

use App\Consts\MessageConst;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExpertReviewRequest extends FormRequest {
    public function rules(): array
    {
        return [
            'evaluation' => 'numeric|between:0.5,5',
            'comment' => 'string|nullable|max:500',
            'expert_id' => 'required|exists:users,id',
            'chatroom_id' => 'required|exists:chatrooms,id'
        ];
    }

    public function attributes()
    {
        return [
            'evaluation' => '満足度',
            'comment' => 'コメント',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
