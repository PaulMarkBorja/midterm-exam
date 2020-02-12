<?php

namespace App\Models\AddOn;

use Illuminate\Database\Eloquent\Model;

class AddOn extends Model
{
    protected $table = 'add_ons';
    protected $fillable = ['name', 'description'];
    public $timestamps = false;

    public function add_on_options()
    {
        return $this->hasMany('App\Models\AddOn\AddOnOption');
    }
}
