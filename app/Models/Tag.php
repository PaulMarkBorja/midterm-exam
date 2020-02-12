<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $guarded = ["id"];
    protected $fillable = ['name'];
    public $timestamps = false;

    public function products()
    {
        return $this->belongsToMany('App\Models\Products\Product');
    }
}
