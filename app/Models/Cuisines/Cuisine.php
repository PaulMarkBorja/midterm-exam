<?php

namespace App\Models\Cuisines;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuisine extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cuisines';
    public $timestamps = false;
    protected $fillable = ['name', 'image'];
}
