<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserActivityLog extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_id', 'action', 'ip_address', 'source', 'location','ticket_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
