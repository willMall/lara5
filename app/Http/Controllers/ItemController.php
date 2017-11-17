<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use EasyWeChat\Factory;
use Ramsey\Uuid\Uuid;

class ItemController extends Controller
{
    public function index($id)
    {
        $attachments = \DB::table('attachments')->select('path')->where(['own'=>1,'own_id'=>$id])->get();
        return view('item', ['item' => Item::findOrFail($id), 'attachments' => $attachments]);
    }
}
