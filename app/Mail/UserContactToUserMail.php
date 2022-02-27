<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class UserContactToUserMail extends Mailable {

    public $userContact;

    public function __construct($userContact) {
        $this->userContact = $userContact;
    }

    public function build() {
        return $this->view('emails.user_contact_to_user')
            ->subject('【kispato】お問い合わせを受け付けました。')
            ->from(env('MAIL_FROM_ADDRESS', 'system@gmail.com'));
    }
}
