<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\NoteService;
use App\Models\FileManager;
use App\Models\Note;
use App\Models\Setting;
use App\Models\User;
use App\Models\Ticket;
use App\Traits\ResponseTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Admin\NoteRequest;

class NoteController extends Controller
{
    use ResponseTrait;
    public $noteService;
    public $ticketTagService;
    public $ticketCategoryService;
    public $ticketDetailsService;
    public function __construct()
    {
        $this->noteService  = new NoteService;
    }
    public function noteStore(NoteRequest $request)
    {
        DB::beginTransaction();
       try {
            if ($request->id) {
                $obj = Note::find($request->id);
                $msg = __("Note Updated successfully");
            } else {
                $obj = new Note();
                $msg = __("Note Created successfully");
            }
           $obj->ticket_id = $request->ticket_id;
           $obj->body = $request->note_details;
           $obj->created_by =  auth()->id();
           $obj->status =  STATUS_ACTIVE;
           $obj->tenant_id =  auth()->user()->tenant_id;
           $obj->save();
           DB::commit();
           return redirect()->back()->with('success', $msg);
       }catch (\Exception $exception){
           DB::rollBack();
           return redirect()->back()->with('error', SOMETHING_WENT_WRONG);
       }
    }
    public function noteDelete($id)
    {
        return $this->noteService->deleteById($id);
    }
}
