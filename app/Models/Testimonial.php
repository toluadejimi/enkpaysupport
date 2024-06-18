<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'image',
        'logo',
        'designation',
        'comment',
        'star',
        'status',
        'created_by',
        'updated_by',
    ];
}
