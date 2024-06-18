<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'blog_category_id',
        'title',
        'slug', //unique
        'details',
        'thumbnail',
        'status',
    ];

    public function tags(){
        return $this->belongsToMany(BlogTag::class, 'blog_tag');
    }
   
    public function author(){
        return $this->belongsTo(User::class, 'user_id');
    }
   
    public function category(){
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }
}
