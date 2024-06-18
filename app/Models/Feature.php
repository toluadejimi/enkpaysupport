<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon',
        'status',
        'created_by',
    ];
}
