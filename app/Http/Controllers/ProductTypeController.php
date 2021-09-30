<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ProductType;

class ProductTypeController extends Controller
{
    public function index($sizeId){
        $types = ProductType::where('product_size_id', $sizeId)->get();
        return response()->json(["types"=>$types]);
    }
}
