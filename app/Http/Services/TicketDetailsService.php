<?php

namespace App\Http\Services;

use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\User;
use App\Models\Ticket;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendEmailGenericJob;
use App\Mail\SendMailGeneric;
use Illuminate\Support\Facades\Mail;
class TicketDetailsService
{
    use ResponseTrait;
    public function getTicketCreatorInfo($id)
    {
        return User::findOrFail($id);
    }

}
