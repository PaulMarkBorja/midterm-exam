<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    protected $table = 'barangays';
    protected $fillable = ['id', 'brgyCode', 'brgyDesc', 'regCode', 'provCode', 'citymunCode'];
    public $timestamps = false;
}
