<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Note extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'ticket_id',
        'body',
        'file_id',
        'created_by',
        'status',
        'tenant_id',
        'created_by',
        'deleted_at',
        'created_at',
        'updated_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
