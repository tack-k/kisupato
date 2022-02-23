<?php

namespace App\Mail;

use App\Models\Admins\UserContactTitle;
use App\Models\Users\UserContact;
use Illuminate\Mail\Mailable;

class UserContactToAdminMail extends Mailable {

    public $userContact;

    public function __construct($userContact) {
        $this->userContact = $userContact;
    }

    public function build() {
        return $this->view('emails.user_contact_to_admin')
            ->subject("【{$this->userContact['name']} 様】お問い合わせのお知らせ")
            ->from(env('MAIL_FROM_ADDRESS', 'system@gmail.com'));

    }
}
