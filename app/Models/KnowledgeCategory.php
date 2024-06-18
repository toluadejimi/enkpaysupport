<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'created_by',
        'updated_by',
    ];

    public function knowledge()
    {
        return $this->hasMany(Knowledge::class);
    }
}
