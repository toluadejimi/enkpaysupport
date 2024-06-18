<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq_category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'created_by',
        'updated_by',
    ];

    public function faq(){
        return $this->hasMany(Faq::class);
    }
}
