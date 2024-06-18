<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mockery\Exception;
use WpOrg\Requests\Auth;

class CollisionDetector extends Controller
{
    use ResponseTrait;
    public function collisionDetector(Request $request){
        try {
            $ticket = Ticket::find($request->ticket_id);
            if(is_null($ticket)){
                return $this->error([], "Ticket Not Found");
            }
            $currentDate = date("Y-m-d");
            $currentTime = date("H:i:s");
            $currentDate = Carbon::parse(date("Y-m-d H:i:s", strtotime($currentDate . $currentTime)));
            $collision_detector_time = Carbon::parse(date('Y-m-d H:i:s', strtotime($ticket->collision_detector)));

            if($ticket->collision_detector != null && $currentDate < $collision_detector_time){
                if($ticket->collision_maker != auth()->id()){
                    return response()->json(['msg' => 'Detected', 'code' => 444]);
                }
                $ticket->collision_detector = $currentDate->addMinutes(5);
                $ticket->save();
                return response()->json(['msg' => 'You have permission', 'code' => 200]);
            }else{
                $ticket->collision_detector = $currentDate->addMinutes(5);
                $ticket->collision_maker = auth()->id();
                $ticket->save();
                return response()->json(['msg' => 'No Detected', 'code' => 222]);
            }
        }catch (Exception $exception){
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

    }
}
