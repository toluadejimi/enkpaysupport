<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FrontendSection extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'title', 'slug', 'has_image', 'description', 'image', 'status', 'created_by'];
}
