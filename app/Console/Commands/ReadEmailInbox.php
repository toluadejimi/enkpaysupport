<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Ticket;
use App\Models\TicketSeenUnseen;
use App\Models\User;

use App\Models\Varity;
use App\Traits\ResponseTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;

class ReadEmailInbox extends Command
{
    use ResponseTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (getOption('email_ticket_config_status')) {
            try {
                $remember_token=Str::random(64);
                $google2fa = app('pragmarx.google2fa');
                $user_status = 'old';
                if (true) {
                    $client = \Webklex\IMAP\Facades\Client::make([
                        'host' => 'imap.gmail.com',
                        'port' => 993,
                        'encryption' => 'ssl',
                        'validate_cert' => true,
                        'username' => getOption('EMAIL_TICKETS_USERNAME'),
                        'password' => getOption('EMAIL_TICKETS_PASSWORD'),
                        'protocol' => 'imap'
                    ]);
                    $client->connect();
                    $aFolder = $client->getFolderByPath('INBOX');
                    $messages = $aFolder->messages()->unseen()->get();
                    foreach($messages as $message){
                        $subject =  $message->getSubject();
                        $body = $message->getHTMLBody(true);
                        $stripped_body = strip_tags($body);
                        $guest = User::where('email', $message->getFrom()[0]->mail)->first();
                        if (is_null($guest)) {
                            $guest =  User::create([
                                'role' => USER_ROLE_CUSTOMER,
                                'name' => 'GUEST',
                                'email' => $message->getFrom()[0]->mail,
                                'password' => Hash::make('!Zaidesk@123'),
                                'status' => USER_STATUS_ACTIVE,
                                'tenant_id' => getTenantId(),
                                'email_verification_status' => 1,
                                'remember_token' => $remember_token,
                                'google2fa_secret' => $google2fa->generateSecretKey(),
                            ]);
                            $user_status = 'new';
                        }
                        $dataObj = new Ticket();

                        $dataObj->ticket_title = $subject;
                        $dataObj->ticket_description = $stripped_body;
                        $dataObj->ticket_type = TICKET_TYPE_INTERNAL;
                        $dataObj->category_id = Category::first()->id;
                        $dataObj->created_by = $guest->id;
                        $dataObj->last_reply_time = now();
                        $dataObj->status = STATUS_PENDING;
                        $dataObj->priority = GENERALLY;
                        $dataObj->tenant_id = getTenantId();
                        $dataObj->save();

                        $getTrackingPreFixed = Varity::first();
                        $getTrackingPreFixed = isset($getTrackingPreFixed->ticket_tracking_no_pre_fixed)?$getTrackingPreFixed->ticket_tracking_no_pre_fixed:'ST';
                        $trackingNo = $getTrackingPreFixed . sprintf('%06d', $dataObj->id);
                        $dataObj->tracking_no = $trackingNo;
                        $dataObj->save();

                        $getAlluser = User::where('tenant_id', $guest->tenant_id)
                            ->where('role','!=',USER_ROLE_CUSTOMER)
                            ->get();

                        $userData = [];
                        foreach ($getAlluser as $singleUser){
                            $userData[] = [
                                'ticket_id'=> $dataObj->id,
                                'created_by'=> $singleUser->id,
                                'tenant_id'=> $singleUser->tenant_id,
                                'is_seen'=> 0,
                            ];
                        }
                        $userData[] = [
                            'ticket_id'=> $dataObj->id,
                            'created_by'=> $guest->id,
                            'tenant_id'=> $guest->tenant_id,
                            'is_seen'=> 1,
                        ];

                        TicketSeenUnseen::insert($userData);

                        DB::commit();
                        if($user_status == 'new'){
                            newEmailTicketEmailNotify($dataObj->id);
                        }else{
                            newTicketEmailNotify($dataObj->id);
                        }
                        $message->setFlag('SEEN');
                        print_r( now());

                    }
                }

            }catch (\Exception $e){
                DB::rollBack();
                print_r($e->getMessage());
            }
        }else{
            echo 'Setup your mail configuration';
        }


    }
}


