<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function sizes(){
        return $this->hasMany('App\ProductSize');
    }
}
