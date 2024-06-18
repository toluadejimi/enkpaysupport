<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class Ticket extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'ticket_title',
        'ticket_description',
        'category_id',
        'subcategory_id',
        'created_by',
        'updated_by',
        'assigned_to',
        'status',
        'priority',
        'file_id',
        'tenant_id',
        'envato_licence',
        'last_reply_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function users(){
        return $this->belongsToMany(User::class,'ticket_assignee','ticket_id','assigned_to')
            ->withTimestamps()
            ->withPivot(['assigned_by','assigned_to','is_active','tenant_id']);
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function tags(){
        return $this->belongsToMany(Tag::class,'ticket_tag','ticket_id','tag_id')->withTimestamps()->withPivot(['tenant_id']);
    }
    public function selfAssigned(){
       return $this->users()->wherePivot('assigned_by',5);
    }
    public function activityLog()
    {
        return $this->hasOne(UserActivityLog::class, 'ticket_id');
    }
    public function fileManager()
    {
        return $this->belongsTo(FileManager::class, 'file_id');
    }
    public function rating()
    {
        return $this->hasOne(TicketRating::class, 'ticket_id');
    }
    public function conversations(){
        return $this->hasMany(Conversation::class,'ticket_id');
    }
    public function lastConversation()
    {
        return $this->hasOne(Conversation::class, 'id','last_reply_id');
    }
    public function lastConversationUser()
    {
        return $this->hasOne(User::class, 'id','last_reply_by');
    }
    public function assignTo(){
        return $this->hasMany(TicketAssignee::class, 'ticket_id')->where('is_active','=', 1);
    }
}
