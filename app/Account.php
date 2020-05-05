<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function orders(){
        return $this->hasMany('App\Order');
    }

    public function quantity(){
        return $this->hasMany('App\OrderProduct')->sum('quantity');
    }

    public function total($id){
        $number = \DB::select("select SUM(products.price * order_products.quantity) AS total from products INNER JOIN order_products ON products.id = order_products.product_id WHERE order_products.order_id = :id", ["id"=>$id]);
        return $number[0]->total;
    }
}
