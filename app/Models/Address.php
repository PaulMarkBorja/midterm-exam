<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $table = 'addresses';
    protected $guarded = ["id"];
    public $timestamps = false;

    public function municipality()
    {
        return $this->belongsTo('App\Models\Municipality');
    }

    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }
}
