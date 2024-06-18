<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPackage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id','package_id','name','number_of_agent','custom_domain_setup','access_community','support','monthly_price','yearly_price','device_limit','start_date','end_date','order_id','status','is_trail'];

}
