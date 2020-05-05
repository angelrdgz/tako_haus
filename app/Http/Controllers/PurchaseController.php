<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Purchase;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::all();
        return view('purchases.index', ["purchases"=>$purchases]);
    }

    public function create()
    {
        return view('purchases.create');
    }

    public function store(Request $request)
    {

        $request->validate(
            [
                'total' => 'required',
                'concept' => 'required',
            ],
            [
                'total.required' => 'El total es requerido',
                'concept.required' => 'El concepto de compra es requerido',
            ]
        );

        $purchase = new Purchase();
        $purchase->total = $request->total;
        $purchase->concept = $request->concept;
        $purchase->save();

        return redirect('compras')->with('success', 'Compra registrada correctamente');

    }

    public function edit($id)
    {
        $purchase = Purchase::find($id);
        return view('purchases.edit', ["purchase"=>$purchase]);
    }

    public function update(Request $request, $id)
    {

        $request->validate(
            [
                'total' => 'required',
                'concept' => 'required',
            ],
            [
                'total.required' => 'El total es requerido',
                'concept.required' => 'El concepto de compra es requerido',
            ]
        );

        $purchase = Purchase::find($id);
        $purchase->total = $request->total;
        $purchase->concept = $request->concept;
        $purchase->save();

        return redirect('compras')->with('success', 'Compra modificada correctamente');

    }
}
