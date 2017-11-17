<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Recommend;
use Auth;
use DB;
use Illuminate\Http\Request;

class RecommendController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $types = config('params.recommend_type');
        $keyword = $request->keyword;
        $type = $request->type;
        if (empty($type)) {
            $type = 1;
        }
        $query = DB::table('recommends');
        $query->leftjoin('items', 'recommends.item_id', '=', 'items.id');
        $query->leftjoin('categories', 'categories.id', '=', 'items.category_id');
        $query->where('recommends.type', '=', $type);
        $query->where(function ($query) use ($keyword) {
            if (!empty($keyword)) {
                $query->where('items.name', 'like', '%' . $keyword . '%');
                $query->orwhere('categories.name', 'like', '%' . $keyword . '%');
            }
        });
        $items = $query->select('items.name', 'recommends.*', 'categories.name as cname')->orderBy('sort', 'desc')->orderBy('id', 'desc')->paginate();
        return view('dashboard.recommend.index', ['items' => $items, 'type' => $types]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $type = $request->type;
        $ids = $request->ids;
        if (empty($ids) || empty($type)) {
            return abort(404);
        }
        DB::transaction(function () use ($type, $ids) {
            foreach ($ids as $key => $value) {
                $recommend = new Recommend;
                $recommend->user_id = Auth::user()->id;
                $recommend->item_id = $value;
                $recommend->type = $type;
                $recommend->save();
            }
        });
        return response()->json(['msg' => '商品推荐成功', 'code' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $types = config('params.recommend_type');
        $keyword = $request->keyword;
        $type = $request->type;
        if (empty($type)) {
            $type = 1;
        }
        $ids = DB::table('recommends')->where('type', $type)->pluck('item_id');
        $query = DB::table('items');
        $query->join('categories', 'categories.id', '=', 'items.category_id');
        $query->where('items.status', '=', 1);
        $query->whereNotIn('items.id', $ids);
        $query->where(function ($query) use ($keyword) {
            if (!empty($keyword)) {
                $query->where('items.name', 'like', '%' . $keyword . '%');
                $query->orwhere('categories.name', 'like', '%' . $keyword . '%');
            }
        });
        $items = $query->select('items.*', 'categories.name as cname')->orderBy('id', 'desc')->paginate();
        return view('dashboard.recommend.show', ['type' => $types, 'items' => $items]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        if (empty($id)) {
            return abort(404);
        }
        if (is_numeric($id)) {
            $re = Recommend::findOrFail($id)->delete();
        } else if (is_array($id)) {
             $re = Recommend::whereIn('id',$id)->delete();
        }
        if ($re) {
            return response()->json(['msg' => '商品移除成功', 'code' => 200]);
        } else {
            return response()->json(['msg' => '商品移除失败', 'code' => 500]);
        }
    }
    public function sort(Request $request)
    {
        $sorts = $request->sorts;
        $ids = $request->ids;
        if (empty($ids) || empty($sorts)||(!is_array($sorts))||(!is_array($ids))) {
            return abort(404);
        }
        DB::transaction(function () use ($sorts, $ids) {
            foreach ($ids as $key => $value) {
                $recommend = Recommend::find($value);
                $recommend->sort =$sorts[$key];
                $recommend->save();
            }
        });
        return response()->json(['msg' => '商品排序成功', 'code' => 200]);
    }
}
