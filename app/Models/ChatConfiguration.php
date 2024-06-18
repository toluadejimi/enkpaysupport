<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatConfiguration extends Model
{
    use HasFactory;
    protected $fillable = [
        'chat_title',
        'message_title',
        'message_discription',
        'created_by',
    ];
}
