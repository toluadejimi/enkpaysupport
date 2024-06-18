<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstantMessage extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'message',
        'status',
        'tenant_id',
        'created_by',
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}
