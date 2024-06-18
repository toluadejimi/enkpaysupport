<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $fillable = [
        'name', //unique
        'slug',
        'status',
    ];

    public function blogs(){
        return $this->hasMany(Blog::class);
    }
}
