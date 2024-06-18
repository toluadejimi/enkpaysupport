<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'email_verified_at',
        'image',
        'address',
        'created_by',
        'role',
        'status',
        'password',
        'remember_token',
        'google2fa_secret',
        'ref_code',
        'tenant_id',
        'google_id',
        'facebook_id',
        'verify_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid = Str::uuid()->toString();
        });
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function tickets(){
        return $this->belongsToMany(Ticket::class,'ticket_assignee','assigned_to','ticket_id')->withTimestamps()->withPivot(['assigned_by','assigned_to','is_active','tenant_id']);
    }
    public function conversations(){
        return $this->belongsToMany(Conversation::class);
    }
    public function selfAssignedTickets(){
        return $this->belongsToMany(Ticket::class,'ticket_assignee','assigned_to','ticket_id')->withTimestamps()->withPivot(['assigned_by','assigned_to','is_active','tenant_id'])->wherePivot('assigned_by',Auth::user()->id)->wherePivot('assigned_to',Auth::user()->id);
    }
    public function myAssignedTickets(){
        return $this->belongsToMany(Ticket::class,'ticket_assignee','assigned_to','ticket_id')->withTimestamps()->withPivot(['assigned_by','assigned_to','is_active','tenant_id'])->wherePivot('assigned_to',Auth::user()->id)->wherePivot('is_active',STATUS_ACTIVE);
    }
    public function getTicketsByUserId($userId){
        return $this->belongsToMany(Ticket::class,'ticket_assignee','assigned_to','ticket_id')->withTimestamps()->withPivot(['assigned_by','assigned_to','is_active','tenant_id'])->wherePivot('assigned_to',$userId);
    }

}
