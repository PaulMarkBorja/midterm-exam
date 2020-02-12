<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $table = 'municipalities';
    protected $fillable = ['id', 'psgcCode', 'citymunDesc', 'regDesc', 'provCode', 'citymunCode'];
    public $timestamps = false;

    public function barangays()
    {
        return $this->hasMany('App\Models\Barangay', 'citymunCode', 'citymunCode');
    }
}
