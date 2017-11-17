<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $ostatus = $request->ostatus;
        $istatus = $request->istatus;
        $query = DB::table('orders as a')->orderBy('a.id', 'desc');
        $query->leftjoin('users as b', 'a.user_id', '=', 'b.id');
        if (!empty($keyword)) {
            $query = $query->where(\DB::raw("CONCAT(`a.name`,`a.uuid`,`a.mobile`)"), 'LIKE', '%' . $keyword . '%');
        }
        if (!empty($ostatus)) {
            $ostatus = intval($ostatus - 1);
            $query = $query->where('a.status', $ostatus);
        }
        if (!empty($istatus)) {
            $query = $query->where('a.schedule', $istatus);
        }
        $items = $query->select('a.*','b.name as agentname')->paginate();
        return view('dashboard.order.index', ['items' => $items]);
    }
    public function send(Request $request)
    {
        $id = $request->id;
        $remarks = $request->remarks;
        if (empty($id)) {
            return abort(404);
        }
        $item = Order::findorfail($id);
        if ($item->status != 1 && $item->schedule != 1) {
            return response()->json(['msg' => '不能进行发货操作', 'code' => 500]);
        } else {
            $item->schedule = 2;
            $item->remarks = $remarks;
            if ($item->save()) {
                return response()->json(['msg' => '发货成功', 'code' => 200]);
            } else {
                return response()->json(['msg' => '发货失败', 'code' => 500]);
            }
        }
    }
    public function show($id)
    {
        if (empty($id)) {
            return abort(404);
        }

        $item = Order::findorfail($id);
        return view('dashboard.order.show', ['item' => $item]);
    }
}
