<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
        $tops = \DB::table('recommends')->join('items', 'recommends.item_id', '=', 'items.id')->where('recommends.type', 2)->select('items.id', 'items.thumb')->take(6)->get();
        $items = \DB::table('recommends')->join('items', 'recommends.item_id', '=', 'items.id')->where('recommends.type', 1)->select('items.id', 'items.name', 'items.thumb', 'items.price')->take(20)->get();
        return view('index', ['items' => $items, 'tops' => $tops]);
    }
}
