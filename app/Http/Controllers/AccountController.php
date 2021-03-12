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
        $products = Product::all();
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

        $hm = (count($request->all()) -2 ) / 2;

        $account = new Account();
        $account->name = $request->name;
        $account->save();

        $total = 0;

        for ($i=1; $i <= $hm; $i++) { 
            $order = new Order();
            $order->account_id = $account->id;
            $order->save();

            foreach ($request->get("id-".$i) as $key => $value) {

                $product = Product::find($request->get("id-".$i)[$key]);
                $total += $product->price * floatval($request->get("quantityItem-".$i)[$key]);

                $accountProduct = new OrderProduct();
                $accountProduct->order_id = $order->id;
                $accountProduct->product_id = $request->get("id-".$i)[$key];
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
        $products = Product::all();
        return view('accounts.edit', ["account" => $account, "products"=>$products]);
    }

    public function update(Request $request, $id)
    {
        $account = Account::find($id);

        foreach ($account->orders as $order) {
            $order->products()->delete();
        }
        $account->orders()->delete();

        $hm = (count($request->all()) - 3 ) / 2;
        $account->name = $request->name;
        $account->save();

        $total = 0;

        for ($i=1; $i <= $hm; $i++) { 
            $order = new Order();
            $order->account_id = $account->id;
            $order->save();

            foreach ($request->get("id-".$i) as $key => $value) {

                $product = Product::find($request->get("id-".$i)[$key]);
                $total += $product->price * floatval($request->get("quantityItem-".$i)[$key]);

                $accountProduct = new OrderProduct();
                $accountProduct->order_id = $order->id;
                $accountProduct->product_id = $request->get("id-".$i)[$key];
                $accountProduct->quantity = $request->get("quantityItem-".$i)[$key];
                $accountProduct->save();
            }
        }

        Account::where('id', $id)->update(["total"=>$total]);

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
            foreach ($account->orders as $order) {
                $order->emptyProducts()->delete();
            }
            $account->orders()->delete();
            $account->closed = true;
            $account->save();

            return response()->json(['data' => true]);
        }
    }
}
