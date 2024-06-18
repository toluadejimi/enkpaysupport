<?php

namespace App\Http\Services;

use App\Models\Note;
use App\Models\Category;
use App\Models\User;
use App\Models\Ticket;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendEmailGenericJob;
use App\Mail\SendMailGeneric;
use Illuminate\Support\Facades\Mail;
class NoteService
{
    use ResponseTrait;
    public function getById($id)
    {
        return Ticket::findOrFail($id);
    }

    public function getNoteData($ticketId){
       $noteData =  Note::with('user')->where(['ticket_id'=>$ticketId,'status'=>STATUS_ACTIVE])->orderBy('created_at','DESC')->get();
       return $noteData;
    }

    public function deleteById($id)
    {
        DB::beginTransaction();
        try {
            $note = Note::where('id', $id)->firstOrFail();
            if(!$note && $note == null){
                return $this->error([], SOMETHING_WENT_WRONG);
            }
            $note->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }
}
