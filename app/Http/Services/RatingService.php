<?php

namespace App\Http\Services;

use App\Mail\UserEmailVerification;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\FileManager;
use App\Models\User;
use App\Models\Ticket;
use App\Models\TicketRating;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendEmailGenericJob;
use App\Mail\SendMailGeneric;
use Illuminate\Support\Facades\Mail;

class   RatingService
{
    use ResponseTrait;


    public function __construct()
    {

    }

    public function list($request)
    {

        $ticketRatingData = TicketRating::with('user', 'ticket')->orderBy('created_at', 'DESC')
            ->select('id', 'ticket_id', 'rating', 'comment', 'customer_id', 'status', 'created_at');


        return datatables($ticketRatingData)
            ->addIndexColumn()
            ->editColumn('customer_id', function ($data) {
                return $data->user->email . '(' . $data->user->name . ')';
            })
            ->editColumn('ticket_id', function ($data) {
                $ticketDetails = '<a href="#" onclick="window.location=\'' . route('admin.tickets.ticket_view', $data->ticket?->id) . '\' " ><h3>' . htmlspecialchars($data->ticket?->ticket_title) . '</h3></a>
                <div>
                  <span>
                    #' . $data->ticket->tracking_no . '
                  </span>
                  <span>
                    <li class="table_date">' . \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d M, Y H:i:s') . '</li>
                  </span>';
                $ticketDetails .= '</div>';
                return $ticketDetails;
            })
            ->editColumn('status', function ($data) {
                if ($data->status == USER_STATUS_ACTIVE) {
                    return '<button class="small-btn pending-btn">Active</button>';
                } else if ($data->status == USER_STATUS_INACTIVE) {
                    return '<button class="small-btn processing-btn">Inactive</button>';
                } else {

                }
            })
            ->editColumn('rating', function ($data) {
                $vrating = '<div class="rate-section">
                <div class="rate">';
                for ($i = 0; $i < $data->rating; $i++) {
                    $vrating .= '<i class="fa fa-star" aria-hidden="true"></i>';
                }
                $vrating .= '</div></div>';
                return $vrating;
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                <button onclick="getEditModal(\'' . route('admin.tickets.ticket-rating-edit', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action me-2 edit" data-toggle="tooltip" title="Edit">
                <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
            </button>
                    <button onclick="deleteItem(\'' . route('admin.tickets.ticket-rating-delete', $data->id) . '\', \'ticketRatingDataTable\')" class="tbl-action-btn text-danger"   title="Delete"><img src="' . asset('admin/images/yajra-datatable/trash.png') . '" alt="delete ticket"></button>
                </div>';
            })
            ->rawColumns(['action', 'status', 'ticket_id', 'rating'])
            ->make(true);
    }

    public function getTicketDeatilsByTicketId($id)
    {
        return Ticket::with('users', 'category', 'activityLog', 'fileManager')->findOrFail($id);
    }

    public function ratingUpdate($request)
    {
        DB::beginTransaction();
        try {
            TicketRating::where(['id' => $request->ticket_rating_id])
                ->update([
                    'status' => $request->status
                ]);
            DB::commit();

            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function deleteById($id)
    {
        DB::beginTransaction();
        try {
            $ticketRating = TicketRating::where('id', $id)->firstOrFail();
            if (!$ticketRating && $ticketRating == null) {
                return $this->error([], SOMETHING_WENT_WRONG);
            }
            $ticketRating->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function ratingStore($request)
    {
        try {
            $agentAssignee = getTicketAssignedAgent($request->target_ticket);
            if (empty($agentAssignee)) {
                return redirect()->back()->with('error', __("Assigned agent not found!"));
            }

            if ($request->target_ticket && $request->target_ticket != null) {
                foreach ($agentAssignee as $agent) {

                    $obj = TicketRating::where(['ticket_id' => $request->target_ticket, 'agent_id' => $agent->id])->first();
                    DB::beginTransaction();
                    if ($obj) {
                        $obj->update([
                            'rating' => $request->rate,
                            'comment' => $request->rating_comment,
                            'category_id' => $request->rating_category,
                        ]);
                        $msg = __("Ticket Rating Updated successfully");
                    } else {
                        $obj = new TicketRating();
                        $obj->ticket_id = $request->target_ticket;
                        $obj->rating = $request->rate;
                        $obj->comment = $request->rating_comment;
                        $obj->category_id = $request->rating_category;
                        $obj->customer_id = auth()->id() != null ? auth()->id() : $request->customer_id;
                        $obj->agent_id = $agent->id;
                        $obj->status = STATUS_ACTIVE;
                        $obj->save();
                        ticketReviewEmailNotify($request->target_ticket);
                        ticketReviewNotify($request->target_ticket);
                        $msg = __("Ticket Rating Created successfully");
                    }
                    DB::commit();

                }
                return redirect()->back()->with('success', $msg);

            } else {
                return redirect()->back()->with('error', SOMETHING_WENT_WRONG);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', SOMETHING_WENT_WRONG);
        }
    }

}
