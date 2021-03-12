<?php

use Illuminate\Support\Facades\DB;
namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public function products(){
        return $this->hasMany('App\OrderProduct');
    }

    public function emptyProducts(){
        return $this->hasMany('App\OrderProduct')->where('quantity', 0);
    }

    public function productsList(){
        return $this->hasMany('App\OrderProduct')->where('quantity', '>', 0);
    }

    public function quantity(){
        return $this->hasMany('App\OrderProduct')->sum('quantity');
    }

    public function total($id){
        $number = \DB::select("select SUM(products.price * order_products.quantity) AS total from products INNER JOIN order_products ON products.id = order_products.product_id WHERE order_products.order_id = :id", ["id"=>$id]);
        return $number[0]->total;
    }
    
}
