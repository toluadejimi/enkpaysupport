<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    public function session_thread(){
        return $this->belongsTo(ChatSession::class,'session_id','id');
    }
}
