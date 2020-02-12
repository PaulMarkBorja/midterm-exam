<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'description', 'category_id', 'store_id', 'image', 'preparation_time', 'available', 'price'];
    public $timestamps = false;

    public function product_options()
    {
        return $this->hasMany('App\Models\Products\ProductOption');
    }
    
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }
}
