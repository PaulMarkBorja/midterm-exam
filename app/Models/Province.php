<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';
    protected $fillable = ['id', 'psgcCode', 'provDesc', 'regCode', 'provCode'];
    public $timestamps = false;

    public function municipalities()
    {
        return $this->hasMany(Municipality::class, 'provCode', 'provCode')
            ->select('id', 'citymunDesc', 'provCode');
    }
}
