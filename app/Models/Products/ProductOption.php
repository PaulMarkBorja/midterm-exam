<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
  protected $table = 'product_options';
  protected $fillable = ['product_id','name','description','price'];
  public $timestamps = false;
}
