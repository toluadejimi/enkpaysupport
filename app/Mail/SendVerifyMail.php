<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendVerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $userData;
    protected $template;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userData, $template)
    {
        $this->template = $template;
        $this->userData = $userData;
    }

    public function build()
    {
        return $this->from(getOption('MAIL_FROM_ADDRESS'), getOption('app_name'))
            ->subject(getEmailTemplate($this->template, 'subject', $this->userData))
            ->markdown('mail.email-verification')
            ->with([
                'template' => $this->template,
                'userData' => $this->userData,
                'link' => route('user.email.verified', $this->userData->remember_token),
            ]);
    }
}
