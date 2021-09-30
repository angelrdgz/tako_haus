<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ProductSize;

class ProductSizeController extends Controller
{
    public function index($productId){
        $sizes = ProductSize::where('product_id', $productId)->get();
        return response()->json(["sizes"=>$sizes]);
    }
}
