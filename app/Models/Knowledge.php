<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Knowledge extends Model
{
    use HasFactory;
    protected $fillable = [
        'knowledge_category_id',
        'title',
        'description',
        'status',
        'created_by',
        'updated_by',
    ];

    public function knowledgeCategory(){
        return $this->belongsTo(KnowledgeCategory::class, 'knowledge_category_id');
    }
}
