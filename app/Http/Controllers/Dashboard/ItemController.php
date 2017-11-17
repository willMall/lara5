<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use Auth;
use Illuminate\Http\Request;

class ItemController extends Controller
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
        $keyword=$request->keyword;
        $query = \DB::table('items');
        $query->join('categories', 'categories.id', '=', 'items.category_id');
        $query->where('items.status', '=', 1);
        $query->where(function ($query) use ($keyword) {
            if (!empty($keyword)) {
                $query->where('items.name', 'like', '%' . $keyword . '%');
                $query->orwhere('categories.name', 'like', '%' . $keyword . '%');
            }
        });
        $items = $query->select('items.*','categories.name as cname')->orderBy('id', 'desc')->paginate();
        return view('dashboard.item.index', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $root = Category::where('parent_id', '=', null)->first();
        $nodes = $root->getDescendants();
        return view('dashboard.item.create', ['nodes' => $nodes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => '请输入商品名称',
            'name.max' => '商品名称最长 :max 个字符',
            'price.required' => '请输入商品价格',
            'price.integer' => '商品价格必须是正整数',
            'stock.required' => '请输入商品库存',
            'stock.integer' => '商品库存必须是正整数',
        ];
        $this->validate($request, [
            'name' => 'required|max:255',
            'price' => 'required|integer',
            'stock' => 'required|integer',
        ], $messages);

        $item = new Item;
        $item->user_id = Auth::user()->id;
        $item->category_id = $request->category_id;
        $item->name = $request->name;
        $item->price = intval($request->price)*100;
        $item->stock = $request->stock;
        $item->details = $request->details;
        if ($item->save()) {
            return redirect('/dashboard/item')->with(['msg' => '商品创建成功', 'code' => 200]);
        } else {
            return redirect('/dashboard/item')->with(['msg' => '商品创建失败', 'code' => 500]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (empty($id)) {
            return abort(404);
        }

        $data = Item::findOrFail($id);
        if ($data->status != 1) {
            return abort(404);
        }
        $node = Category::find( $data->category_id);
        $nodes = $node->getAncestorsAndSelf();
        return view('dashboard.item.show', ['data' => $data, 'nodes' => $nodes]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (empty($id)) {
            return abort(404);
        }

        $data = Item::findOrFail($id);
        if ($data->status != 1) {
            return abort(404);
        }
        $root = Category::where('parent_id', '=', null)->first();
        $nodes = $root->getDescendants();
        return view('dashboard.item.edit', ['data' => $data, 'nodes' => $nodes]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $messages = [
            'name.required' => '请输入商品名称',
            'name.max' => '商品名称最长 :max 个字符',
            'price.required' => '请输入商品价格',
            'price.integer' => '商品价格必须是正整数',
            'stock.required' => '请输入商品库存',
            'stock.integer' => '商品库存必须是正整数',
        ];
        $this->validate($request, [
            'name' => 'required|max:255',
            'price' => 'required|integer',
            'stock' => 'required|integer',
        ], $messages);
        $id = $request->id;
        if (empty($id)) {
            return abort(404);
        }

        $item = Item::findOrFail($id);
        if ($item->status != 1) {
            return abort(404);
        }
        $item->category_id = $request->category_id;
        $item->name = $request->name;
        $item->price = intval($request->price)*100;
        $item->stock = $request->stock;
        $item->details = $request->details;
        if ($item->save()) {
            return redirect('/dashboard/item')->with(['msg' => '商品修改成功', 'code' => 200]);
        } else {
            return redirect('/dashboard/item')->with(['msg' => '商品修改失败', 'code' => 500]);
        }
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

        $item = Item::findOrFail($id);
        if ($item->status != 1) {
            return abort(404);
        }
        $item->status = 0;
        if ($item->save()) {
            return response()->json(['msg' => '商品删除成功', 'code' => 200]);
        } else {
            return response()->json(['msg' => '商品删除失败', 'code' => 500]);
        }
    }
    public function upload($id)
    {
        if (empty($id)) {
            return abort(404);
        }

        $data = Item::findOrFail($id);
        if ($data->status != 1) {
            return abort(404);
        }
        $files = \DB::table('attachments')->where(['own' => 1, 'own_id' =>$id, 'type' => 'files'])->get();
        return view('dashboard.item.upload', ['data' => $data]);
    }
    public function uploader(Request $request)
    {
       //dd($request->all());
       return response()->json(['msg' => '商品删除成功', 'code' => 200]);
    }
    public function getpic(Request $request)
    {
        $id=$request->id;
        if (empty($id)) {
            return abort(404);
        }

        $data = Item::findOrFail($id);
        if ($data->status != 1) {
            return abort(404);
        }
        $files = \DB::table('attachments')->where(['own' => 1, 'own_id' =>$id, 'type' => 'files'])->get();
        $previewList=array();
        $previewConfig=array();
        foreach ($files as $key => $value) {
            $path=$value->path;
            $picName=substr($path, 7);
            $previewList[$key]='/storage/'.$path;
            $previewConfig[$key]['key']=$path;
            $previewConfig[$key]['caption']=$picName;
        }
        $info['previewList']=$previewList;
        $info['previewConfig']=$previewConfig;
        return response()->json($info);
    }
}
