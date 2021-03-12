<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', ["products"=>$products]);
    }

    public function create()
    {
        return view("products.create");
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'price' => 'required',
                'description' => 'required',
            ],
            [
                'name.required' => 'El nombre es requerido',
                'price.required' => 'El precio es requerido',
                'description.required' => 'La descripción es requerida',
            ]
        );

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        return redirect('productos')->with('success', 'Producto registrado correctamente');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return view("products.edit", ["product"=>$product]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'price' => 'required',
                'description' => 'required',
            ],
            [
                'name.required' => 'El nombre es requerido',
                'price.required' => 'El precio es requerido',
                'description.required' => 'La descripción es requerida',
            ]
        );

        $product = Product::find($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        return redirect('productos')->with('success', 'Producto modificado correctamente');
    }
}
