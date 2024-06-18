<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CmsSetting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'auth_page_title',
        'auth_page_sub_title',
        'app_footer_text',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'twitter_url',
        'skype_url',
        'tenant_id',
        'created_by'
    ];
}
