<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'faq_category_id',
        'question',
        'answer',
        'status',
        'created_by',
        'updated_by',
    ];

    public function faqCategory(){
        return $this->belongsTo(Faq_category::class, 'faq_category_id');
    }

}
