<?php

namespace App\Models\AddOn;

use Illuminate\Database\Eloquent\Model;

class AddOnOption extends Model
{
    protected $table = 'add_on_options';
    protected $fillable = ['add_on_id', 'name', 'description', 'price'];
    public $timestamps = false;
}
