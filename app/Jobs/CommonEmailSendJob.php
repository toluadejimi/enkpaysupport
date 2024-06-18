<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class CommonEmailSendJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $template;
    protected $data;
    protected $user;
    protected $subject;
    protected $defaultEmail;
    protected $defaultName;



    /**
     * CommonEmailSendJob constructor.
     * @param $data
     * @param $template
     * @param $subject
     * @param $user
     */
    public function __construct($data, $template, $subject, $user) {
        $this->data = $data;
        $this->template = $template;
        $this->subject = $subject;
        $this->user = $user;
        $this->defaultEmail = env('MAIL_FROM_ADDRESS','');
        $this->defaultName = env('MAIL_FROM_NAME','');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $user = $this->user;
        $subject = $this->subject;
        try {
            Mail::send($this->template, $this->data, function ($message) use ($user, $subject) {
                $message->to($user->email, $user->name)->subject($subject)->from(
                    $this->defaultEmail, $this->defaultName
                );
            });

        } catch (\Exception $e) {
        }
    }
}
