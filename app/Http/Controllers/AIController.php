<?php

namespace App\Http\Controllers;

use App\Models\AIReplay;
use App\Models\Conversation;
use App\Models\Ticket;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenAI;

class AIController extends Controller
{
    use ResponseTrait;

    public function aiReplayGenerate(Request $request)
    {

        try {
            $getTicketData = Ticket::where('id', $request->id)->first();
            $getReplayData = Conversation::where('ticket_id', $request->id)->get();

            $promt = 'Ticket details: ' . strip_tags($getTicketData->ticket_description) . ', ';

            if ($getReplayData && $getReplayData != null) {
                foreach ($getReplayData as $data) {
                    if (getRoleByUserId($data->created_by) == USER_ROLE_AGENT || getRoleByUserId($data->created_by) == USER_ROLE_ADMIN) {
                        $promt .= 'Agent says: ' . strip_tags($data->body) . ', ';
                    } else {
                        $promt .= 'Customer says: ' . strip_tags($data->body) . ', ';
                    }
                }
            }

            $apiKey = '';

            if (getOption('chat_gtp_api_key') != null) {
                $apiKey = getOption('chat_gtp_api_key');

            } else {
                return $this->error([], 'Api key not found! ');
            }

            $client = OpenAI::client($apiKey);


            $result = $client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                "temperature" => 0,
                'messages' => [
                    ["role" => "user", "content" => $promt],
                ],
            ]);


            $data['replayText'] = $result['choices'][0]['message']['content'];

            if ($data['replayText']) {
                $aiObj = new AIReplay();
                $aiObj->ticket_id = $getTicketData->id;
                $aiObj->ai_replay_text = $data['replayText'];
                $aiObj->save();
            }
            $data['generate_id'] = $aiObj->id;
            return $this->success($data, __("Generated Successfully"));

        } catch (Exception $exception) {
            return $this->error([], $exception->getMessage());
        }

    }

    public function aiReplayDelete(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = AIReplay::where('id', $request->id)->firstOrFail();
            if (!$data && $data == null) {
                return $this->error([], SOMETHING_WENT_WRONG);
            }
            $data->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }
}
