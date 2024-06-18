<?php

namespace App\Jobs;

use App\Models\SendMailRecord;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendMassMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $numberOfUser;


    public function __construct($data, $numberOfUser)
    {
        $this->data = $data;
        $this->numberOfUser = $numberOfUser;
    }


    public function handle()
    {


    }
}
