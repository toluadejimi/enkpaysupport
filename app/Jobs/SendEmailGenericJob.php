<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailGeneric;

class SendEmailGenericJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;
    public $subject;
    public $emailBody;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userData, $subject,$emailTemplateBody)
    {
        $this->user = $userData;
        $this->subject = $subject;
        $this->emailBody = $emailTemplateBody;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Mail::to($this->user->email)->send(new SendMailGeneric($this->user, $this->subject,$this->emailBody));

        } catch (\Exception $e) {
        }
    }
}
