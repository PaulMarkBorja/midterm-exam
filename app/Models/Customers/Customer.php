<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'first_name', 'last_name', 'gender', 'birth_date',
        'phone', 'address', 'user_id'
    ];

    public function user() {
        return $this->hasOne('App\Models\User');
    }
}
