<?php

namespace App\Models\Stores;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'type_id',
        'name',
        'email',
        'image',
        'phone',
        'is_open',
        'is_active',
    ];

    public function users() {
        return $this->hasMany('App\Models\User');
    }
}
