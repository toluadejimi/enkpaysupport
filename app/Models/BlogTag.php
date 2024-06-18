<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    protected $fillable = [
        'name', //unique
        'slug',
    ];

    public function blogs(){
        return $this->belongsToMany(Blog::class);
    }
}
