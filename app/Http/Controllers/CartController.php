<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ShoppingCart;
use App\Models\Item;

class CartController extends Controller
{
    public function index()
    {
        return view('cart');
    }

    public function api()
    {
        $carts = ShoppingCart::all();
        $ids = $carts->pluck('id');
        $items = \DB::table('items')->select('id', 'price', 'thumb')->whereIn('id', $ids)->get()->keyBy('id');
        $result = [];
        foreach ($carts as $cart) {
            if (isset($items[$cart->id])) {
                ShoppingCart::update($cart->rawId(), ['price' => $items[$cart->id]->price]);
            }
            $cart['thumb'] = $items[$cart->id]->thumb;
            $result[] = $cart;
        }
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = Item::find($request->item_id);
        $row = ShoppingCart::add($item->id, $item->name, 1, $item->price);
        return response()->json($row);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
