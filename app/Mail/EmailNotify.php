<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailNotify extends Mailable
{
    use Queueable, SerializesModels;

    protected $ticketData;
    protected $userData;
    protected $templeate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticketData, $userData, $templeate)
    {
        $this->ticketData = $ticketData;
        $this->userData = $userData;
        $this->templeate = $templeate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(getOption('MAIL_FROM_ADDRESS'), getOption('app_name'))
            ->subject(getEmailTemplate($this->templeate, 'subject', $link = '', $this->ticketData, $this->userData))
            ->markdown('mail.email-notify')
            ->with([
                'ticketData' => $this->ticketData,
                'userData' => $this->userData,
                'templeate' => $this->templeate,
            ]);
    }
}
