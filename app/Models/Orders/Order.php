<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = 'orders';
    protected $guarded = ["id"];
    protected $fillable = ['pickupaddress', 'dropoffaddress', 'total_amount', 'order_datetime', 'order_status', 'status', 'customer_id', 'business_id', 'driver_id', 'lat', 'lng', 'recipient', 'amount_tendered', 'change', 'etd', 'delivery_address', 'recipientname', 'recipientemail', 'recipientnumber', 'notes', 'order_code', 'reason', 'notes_driver'];

    public function products()
    {
        return $this->belongsToMany('App\Models\Products\Product')->withPivot('quantity');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customers\Customer', 'customer_id', 'id');
    }

    public function business()
    {
        return $this->belongsTo('App\Models\Stores\Store', 'store_id', 'id');
    }

    // public function feedback()
    // {
    //     return $this->hasOne('App\Models\Feedback');
    // }

    public function driver()
    {
        return $this->belongsTo('App\Models\Drivers\Driver', 'driver_id', 'id');
    }
}
