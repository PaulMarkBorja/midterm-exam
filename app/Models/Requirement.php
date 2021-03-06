<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requirement extends Model
{
    use SoftDeletes;

    protected $table = 'requirements';
    protected $redis;
    protected $guarded = ["id"];
    protected $fillable = ['name', 'indicator'];
    public $timestamps = false;
}
