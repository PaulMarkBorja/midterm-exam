<?php

namespace App\Models\Stores;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreType extends Model
{
    use SoftDeletes;
    protected $table = 'store_types';
    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $fillable = ['name'];
}
