<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class TicketRating extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'ticket_id',
        'rating',
        'comment',
        'customer_id',
        'category_id',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id')->withTrashed();
    }
}
