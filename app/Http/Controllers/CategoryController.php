<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('parent_id', null)->first()->children()->get(['id', 'name']);
        return view('category.index', ['categories' => $categories->toJson()]);
    }

    public function api($categoryID = '2')
    {
        $items = Item::where('category_id', $categoryID)->where('status', 1)->get();
        return response()->json($items);
    }
}
