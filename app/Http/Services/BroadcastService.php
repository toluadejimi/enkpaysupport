<?php


namespace App\Http\Services;


use App\Models\DeviceConfirmation;
use App\Models\User;
use App\Models\WebSocketToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Pusher\Pusher;

class BroadcastService
{
    protected $broadcast;

    public function __construct()
    {
        $config = config('broadcasting.connections.pusher');
        $this->broadcast = new Pusher($config['key'], $config['secret'], $config['app_id'], $config['options']);
    }

    public function broadCast(string $channelName, string $eventName, $data)
    {
         return $this->broadcast->trigger($channelName, $eventName, $data);
    }

}
