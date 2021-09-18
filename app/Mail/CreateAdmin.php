<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Inertia\Inertia;

class CreateAdmin extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
        $this->login_url = route('admin.login');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.admin_create')
            ->subject('【重要:キスパト】アカウント新規発行のお知らせ')
            ->with([
                'email' => $this->email,
                'password' => $this->password,
                'login_url' => $this->login_url,
            ]);

    }
}
