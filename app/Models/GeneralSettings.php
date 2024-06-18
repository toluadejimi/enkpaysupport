<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, int $int)
 */
class GeneralSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_name',
        'app_email',
        'app_contact_number',
        'app_location',
        'app_copyright',
        'app_developed',
        'app_timezone',
        'app_debug',
        'app_date_format',
        'app_time_format',
        'app_preloader',
        'app_logo',
        'app_fav_icon',
        'app_footer_logo',
        'login_left_image',
        'tenant_id',
        'created_by'
    ];
}
