<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Meat;
use App\ProductSize;
use App\ProductType;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', ["products" => $products]);
    }

    public function create()
    {
        $meats = Meat::orderBy('name', 'ASC')->get();
        return view("products.create", ["meats" => $meats]);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'description' => 'required',
            ],
            [
                'name.required' => 'El nombre es requerido',
                'description.required' => 'La descripción es requerida',
            ]
        );

        $product = new Product();
        $product->name = $request->name;
        $product->size = $request->size ? true : false;
        $product->type = $request->type ? true : false;
        $product->description = $request->description;
        $product->save();

        foreach ($request->sizeName as $key => $value) {
            $productSize = new ProductSize();
            $productSize->product_id = $product->id;
            $productSize->size = $value;
            $productSize->price = $request->sizePrice[$key];
            $productSize->save();

            if ($request->type) {

                foreach ($request["typeName" . (intval($key) + 1)] as $key2 => $val) {
                    $productType = new ProductType();
                    $productType->product_id = $product->id;
                    $productType->product_size_id = $productSize->id;
                    $productType->name = $val;
                    $productType->price = $request["typePrice" . (intval($key) + 1)][$key2];
                    $productType->save();
                }
            }
        }

        return redirect('productos')->with('success', 'Producto registrado correctamente');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return view("products.edit", ["product" => $product]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'description' => 'required',
            ],
            [
                'name.required' => 'El nombre es requerido',
                'description.required' => 'La descripción es requerida',
            ]
        );

        $request->validate(
            [
                'name' => 'required',
                'description' => 'required',
            ],
            [
                'name.required' => 'El nombre es requerido',
                'description.required' => 'La descripción es requerida',
            ]
        );

        $product = Product::find($id);
        $product->name = $request->name;
        $product->size = $request->size ? true : false;
        $product->type = $request->type ? true : false;
        $product->description = $request->description;
        $product->save();

        foreach ($product->sizes as $size){
            $size->types()->delete();
        }

        $product->sizes()->delete();

        foreach ($request->sizeName as $key => $value) {
            $productSize = new ProductSize();
            $productSize->product_id = $product->id;
            $productSize->size = $value;
            $productSize->price = $request->sizePrice[$key];
            $productSize->save();

            if ($request->type) {

                foreach ($request["typeName" . (intval($key) + 1)] as $key2 => $val) {
                    $productType = new ProductType();
                    $productType->product_id = $product->id;
                    $productType->product_size_id = $productSize->id;
                    $productType->name = $val;
                    $productType->price = $request["typePrice" . (intval($key) + 1)][$key2];
                    $productType->save();
                }
            }
        }

        return redirect('productos')->with('success', 'Producto modificado correctamente');
    }

    public function destroy($id){
        $product = Product::find($id);

        if($product->has('sizes')){
            foreach($product->sizes as $key => $size){
                if($size->has('types')){
                    $size->types()->delete();
                }
            }
            $product->sizes()->delete();
        }

        $product->delete();
        
        return redirect('productos')->with('success', 'Producto eliminado correctamente');
    }
}
