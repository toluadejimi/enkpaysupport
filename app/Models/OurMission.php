<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurMission extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'description_point',
        'image'
    ];

    protected $casts = [
        'description_point' => 'array'
    ];
}
