<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    public $timestamps = false;

    public function types(){
        return $this->hasMany('App\ProductType', 'product_size_id', 'id');
    }
}
