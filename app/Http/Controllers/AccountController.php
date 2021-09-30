<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Account;
use App\Order;
use App\Product;
use App\OrderProduct;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::where('closed', false)->get();
        return view('accounts.index', ['accounts' => $accounts]);
    }

    public function create()
    {
        $products = Product::orderBy('name', 'ASC')->get();
        return view('accounts.create', ["products" => $products]);
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

        $account = new Account();
        $account->name = $request->name;
        $account->save();

        $total = 0;

        for ($i=1; $i <= $request->count; $i++) { 
            $order = new Order();
            $order->account_id = $account->id;
            $order->onion = $request->get("onion-".$i);
            $order->cilantro = $request->get("cilantro-".$i);
            $order->save();

            foreach ($request->get("productId-".$i) as $key => $value) {
                $total += $request->get("priceItem-".$i)[$key] * floatval($request->get("quantityItem-".$i)[$key]);

                $accountProduct = new OrderProduct();
                $accountProduct->order_id = $order->id;
                $accountProduct->product_id = $request->get("productId-".$i)[$key];
                $accountProduct->product_size_id = $request->get("sizeId-".$i)[$key];
                $accountProduct->product_type_id = $request->get("typeId-".$i)[$key];
                $accountProduct->price = $request->get("priceItem-".$i)[$key];
                $accountProduct->quantity = $request->get("quantityItem-".$i)[$key];
                $accountProduct->save();
            }
        }

        Account::where('id', $account->id)->update(["total"=>$total]);

        return redirect('cuentas');
    }

    public function edit($id)
    {
        $account = Account::find($id);
        $products = Product::orderBy('name', 'ASC')->get();
        return view('accounts.edit', ["account" => $account, "products"=>$products]);
    }

    public function update(Request $request, $id)
    {
        $account = Account::find($id);

        foreach ($account->orders as $order) {
            $order->products()->delete();
        }
        $account->orders()->delete();

        $hm = (count($request->all()) - 3 ) / 4;
        $account->name = $request->name;
        $account->save();

        $total = 0;

        for ($i=1; $i <= $request->count; $i++) { 
            $order = new Order();
            $order->account_id = $account->id;
            $order->onion = $request->get("onion-".$i);
            $order->cilantro = $request->get("cilantro-".$i);
            $order->save();

            foreach ($request->get("productId-".$i) as $key => $value) {
                $total += $request->get("priceItem-".$i)[$key] * floatval($request->get("quantityItem-".$i)[$key]);

                $accountProduct = new OrderProduct();
                $accountProduct->order_id = $order->id;
                $accountProduct->product_id = $request->get("productId-".$i)[$key];
                $accountProduct->product_size_id = $request->get("sizeId-".$i)[$key];
                $accountProduct->product_type_id = $request->get("typeId-".$i)[$key];
                $accountProduct->price = $request->get("priceItem-".$i)[$key];
                $accountProduct->quantity = $request->get("quantityItem-".$i)[$key];
                $accountProduct->save();
            }
        }

        Account::where('id', $account->id)->update(["total"=>$total]);

        return redirect('cuentas');
    }

    public function destroy(Request $request, $id)
    {
        $account = Account::find($id);
        if ($request->order === NULL) {

            foreach ($account->orders as $order) {
                $order->products()->delete();
            }
            $account->orders()->delete();
            
            $account->delete();

            return redirect('cuentas');
        } else {
            $account->closed = true;
            $account->save();

            return response()->json(['data' => true]);
        }
    }
}
