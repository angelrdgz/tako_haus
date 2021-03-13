<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Order;
use App\Product;
use App\OrderProduct;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('closed', false)->get();
        return view('orders.index', ['orders' => $orders]);
    }

    public function create()
    {
        $products = Product::orderBy('name', 'DESC')->get();
        return view('orders.create', ["products" => $products]);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'El nombre es requerido',
            ]
        );

        $order = new Order();
        $order->name = $request->name;
        $order->save();

        foreach ($request->id as $key => $item) {
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $request->id[$key];
            $orderProduct->quantity = $request->quantityItem[$key];
            $orderProduct->save();
        }

        return redirect('ordenes');
    }

    public function edit($id)
    {
        $order = Order::find($id);
        return view('orders.edit', ["order" => $order]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $order->products()->delete();

        foreach ($request->id as $key => $item) {
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $request->id[$key];
            $orderProduct->quantity = $request->quantityItem[$key];
            $orderProduct->save();
        }

        return redirect('ordenes');
    }

    public function destroy(Request $request, $id)
    {
        $order = Order::find($id);
        if ($request->order === NULL) {
            $order->products()->delete();
            $order->delete();

            return redirect('ordenes');
        } else {
            $order->closed = true;
            $order->save();

            return response()->json(['data' => true]);
        }
    }
}
