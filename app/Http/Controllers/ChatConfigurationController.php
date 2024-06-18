<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ChatConfigurationRequest;
use App\Models\ChatConfiguration;
use Exception;
use Illuminate\Support\Facades\DB;

class ChatConfigurationController extends Controller
{
    public function chatConfigur(ChatConfigurationRequest $request)
    {

        DB::beginTransaction();
        try {

            $checkDataExistOrNot = ChatConfiguration::where('created_by', auth()->id())->first();

            if ($checkDataExistOrNot && $checkDataExistOrNot != null) {
                $checkDataExistOrNot->chat_title = $request->chat_title;
                $checkDataExistOrNot->message_title = $request->message_title;
                $checkDataExistOrNot->message_discription = $request->message_discription;
                $checkDataExistOrNot->save();
            } else {
                $chatConfiguration = new ChatConfiguration();
                $chatConfiguration->chat_title = $request->chat_title;
                $chatConfiguration->message_title = $request->message_title;
                $chatConfiguration->message_discription = $request->message_discription;
                $chatConfiguration->created_by = auth()->id();
                $chatConfiguration->save();
            }
            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(getMessage(SOMETHING_WENT_WRONG));
        }
    }
}
