<?php

namespace App\Models\Drivers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    //
    use SoftDeletes;

    protected $table = 'drivers';
    protected $redis;
    protected $guarded = ["id"];
    protected $fillable = ['driver_code', 'first_name', 'middle_name', 'suffix', 'last_name', 'gender', 'civil_status', 'citizenship', 'mobile_number', 'created_by', 'modified_by', 'vehicle_id', 'schedcode', 'status', 'user_id', 'login', 'image'];

    // public function requirements()
    // {
    //     return $this->belongsToMany('App\Models\Requirement')->withPivot('notes', 'status', 'name');
    // }

    // public function vehicle()
    // {
    //     return $this->belongsTo('App\Models\Vehicle', 'vehicle_id', 'id');
    // }

    // public function driverlocation()
    // {
    //     return $this->hasOne('App\Models\DriverLocation');
    // }

    // public function bookings()
    // {
    //     // return $this->hasManyThrough(
    //     //     'App\Models\Booking', 'App\Models\BookingInformation','booking_id', 'id'
    //     // );
    //     return $this->hasMany('App\Models\BookingInformation');
    // }

    // public function restaurants()
    // {
    //     return $this->belongsToMany('App\Models\Business');
    // }

    // public function orders()
    // {
    //     return $this->hasMany('App\Models\Order');
    // }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function address()
    {
        return $this->hasOne('App\Models\Address');
    }
}