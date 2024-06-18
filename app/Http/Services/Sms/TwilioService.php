<?php

namespace App\Http\Services\Sms;

use App\Traits\ResponseTrait;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class TwilioService
{

    use ResponseTrait;

    public static function sendSms($phoneNo, $otp, $smsText)
    {


        if (getOption('app_sms_status') != 1) {
            return false;
        }


        $sid = getOption('TWILIO_ACCOUNT_SID');
        $token = getOption('TWILIO_AUTH_TOKEN');
        $from_number = getOption('TWILIO_PHONE_NUMBER');

        try {
            $client = new Client($sid, $token);
        } catch (ConfigurationException $e) {
            return false;
        }

        $sendStatus = $client->messages->create(
            $phoneNo,
            [
                'from' => $from_number,
                'body' => $smsText
            ]
        );

        if ($sendStatus->status == 'queued' || $sendStatus->status == 'delivered') {
            return true;
        } else {
            return false;
        }
    }
}
