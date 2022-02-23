<?php

namespace App\Mail;

use App\Models\Admins\UserContactTitle;
use App\Models\Users\UserContact;
use Illuminate\Mail\Mailable;

class UserContactToAdminMail extends Mailable {

    public $userContact;

    public function __construct($userContact) {
        $this->userContact = $userContact;
        $title = UserContactTitle::find($userContact['user_contact_title_id']);
        $this->userContact['title'] = $title['name'];
    }

    public function build() {
        return $this->view('emails.user_contact_to_admin')
            ->subject('【ユーザー】お問い合わせのお知らせ')
            ->from(env('MAIL_FROM_ADDRESS', 'system@gmail.com'));

    }
}
