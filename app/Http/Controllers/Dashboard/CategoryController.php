<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
    public function index()
    {
        $root = Category::where('parent_id', '=', null)->first();
        $node = $root->getDescendants();
        $nodes = $root->getDescendantsAndSelf();
        return view('dashboard.category.index', ['data' => $node, 'nodes' => $nodes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $root = Category::where('parent_id', '=', null)->first();
        $node = $root->getDescendantsAndSelf();
        return view('dashboard.category.create', ['data' => $node]);
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
            'name.required' => '请输入分类名称',
            'name.max' => '产品名称最长 :max 个字符',
        ];
        $this->validate($request, [
            'name' => 'required|max:255',
        ], $messages);
        $id = $request->parent_id;
        if (empty($id)) {
            $re = Category::create(['name' => $request->name]);
        } else {
            $tarNode = Category::findOrFail($id);
            if ($tarNode->depth == 3) {
                return redirect('/dashboard/category')->with(['msg'=>'分类只支持三级分类','code'=>500]);
            }
            $node = Category::create(['name' => $request->name, 'parent_id' => $id]);
            $re = $node->makeChildOf($tarNode);
            if ($re) {
                return redirect('/dashboard/category')->with(['msg'=>'分类创建成功','code'=>200]);
            } else {
                return redirect('/dashboard/category')->with(['msg'=>'分类创建失败','code'=>500]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function moved(Request $request)
    {
        $nodeId = intval($request->nodeid);
        $tarNodeId = intval($request->tnodeid);
        $nodePos = intval($request->movepos);
        if (empty($nodeId) || empty($tarNodeId)) {
            return abort(404);
        }

        if ($nodeId == $tarNodeId) {
            return response()->json(['code' => 500, 'msg' => '要移动的分类与目标分类不能为同一分类']);
        }

        $nodes = Category::findOrFail($nodeId);
        $depthData = $nodes->getLeaves()->toArray();
        $depth = 1;
        if (!empty($depthData)) {
            $depth = $depthData[0]['depth'] - $nodes->depth + 1;
        }
        $tar_node = Category::findOrFail($tarNodeId);
        $tarDepthData = $tar_node->getLeaves()->toArray();
        $tar_depth = 1;
        if (!empty($tarDepthData)) {
            $tar_depth = $tarDepthData[0]['depth'] - $tar_node->depth + 1;
        }
        if (($nodes->parent_id != $tar_node->parent_id) || ($depth != $tar_depth)) //不同级移动
        {
            if (($depth == 1 && $tar_node->depth == 3) || ($depth == 2 && $tar_node->depth >= 2) || ($depth == 3)) {
                return response()->json(['code' => 500, 'msg' => '分类只支持三级分类,操作失败']);
            }
            $nodes->parent_id = $tar_node->id;
            if ($nodePos == 1) {
                $re = $nodes->makeFirstChildOf($tar_node);
            }
            if ($nodePos == 2) {
                $re = $nodes->makeLastChildOf($tar_node);
            }
        } else {
            //同级移动
            if ($nodePos == 1) {
                $re = $tar_node->moveToRightOf($nodes);
            }

            if ($nodePos == 2) {
                $re = $tar_node->moveToLeftOf($nodes);
            }
        }

        if ($re) {
            return response()->json(['code' => 200, 'msg' => '分类移动成功']);
        } else {
            return response()->json(['code' => 500, 'msg' => '分类移动失败']);
        }
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
            abort(404);
        }

        $node = Category::findOrFail($id);
        return view('dashboard.category.edit', ['data' => $node]);
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
        $id = $request->id;
        if (empty($id)) {
            abort(404);
        }

        $tarNode = Category::findOrFail($id);
        $tarNode->name = $request->name;
        if ($tarNode->save()) {
            return response()->json(['code' => 200, 'msg' => '更新成功']);
        } else {
            return response()->json(['code' => 500, 'msg' => '更新失败']);
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
            abort(404);
        }

        $node = Category::findOrFail($id);
        if ($node->delete()) {
            return response()->json(['code' => 200, 'msg' => '删除成功']);
        } else {
            return response()->json(['code' => 500, 'msg' => '删除失败']);
        }
    }
}
