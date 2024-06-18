<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Arr;
use App\Http\Services\TicketService;
use App\Http\Services\RatingService;
use App\Models\FileManager;
use App\Models\Setting;
use App\Models\User;
use App\Models\Ticket;
use App\Models\TicketRating;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Services\TicketDetailsService;
use App\Http\Requests\customer\TicketRatingRequest;

class TicketRatingController extends Controller
{
    use ResponseTrait;
    public $ticketService;
    public $ratingService;
    public $ticketDetailsService;
    public function __construct()
    {
        $this->ticketService = new TicketService;
        $this->ratingService = new RatingService;
        $this->ticketDetailsService = new TicketDetailsService;
    }
    public function manageTicketRatings(Request $request)
    {
        if ($request->ajax()) {
            return $this->ratingService->list($request);
        } else {
            $data['pageTitle'] = __('Ticket Rating');
            $data['navTicketRatingClass'] = 'mm-active';
            $data['targetDataUrl'] = route('admin.tickets.manageTicketRatings');
            return view('admin.tickets.ratings.index', $data);
        }
    }

    public function ticketRatingEdit($id)
    {
        $data['ticket_rating'] = TicketRating::findOrFail($id);
        return view('admin.tickets.ratings.ticket_rating_update_form', $data);
    }

    public function ticketRatingUpdate(Request $request)
    {
       return $this->ratingService->ratingUpdate($request);
    }

    public function ticketRatingDelete($id)
    {
        return $this->ratingService->deleteById($id);
    }

    public function ticketRatingStore(TicketRatingRequest $request)
    {
        return $this->ratingService->ratingStore($request);
    }
    public function guestTicketRatingStore(TicketRatingRequest $request)
    {
        return $this->ratingService->ratingStore($request);
    }
}
