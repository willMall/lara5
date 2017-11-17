<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Auth;
use Illuminate\Http\Request;
use Storage;
use DB;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Ad::where('type', 1)->orderBy('sort', 'desc')->orderBy('id', 'desc')->paginate();
        return view('dashboard.ads.index', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.ads.create');
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
            'title.required' => '请输入广告标题',
            'path.required' => '请选择要上传的图片',
            'type.required' => '请选择广告类型',
        ];
        $this->validate($request, [
            'title' => 'required|max:255',
            'path' => 'required|max:255',
            'type' => 'required',
        ], $messages);

        if (!$request->hasFile('path')) {
            return abort(500, '上传文件为空');
        }
        $file = $request->file('path');
        if (!starts_with($file->getMimeType(), 'image')) {
            return abort(500, '上传文件类型错误');
        }
        if (!$file->isValid()) {
            return abort(500, '上传文件出错');
        }
        $newFileName = md5(time() . rand(0, 10000)) . '.' . $file->getClientOriginalExtension();
        $savePath = date('Ym', time()) . '/' . $newFileName;
        $bytes = Storage::put(
            $savePath,
            file_get_contents($file->getRealPath())
        );
        if (!Storage::exists($savePath)) {
            return abort(500, '保存文件出错');
        }
        $item = new Ad;
        $item->user_id = Auth::user()->id;
        $item->title = $request->title;
        $item->url = $request->url;
        $item->sort = $request->sort ? $request->sort : 1;
        $item->type = $request->type;
        $item->path = $savePath;
        if ($item->save()) {
            return redirect('/dashboard/ads')->with(['msg' => '广告创建成功', 'code' => 200]);
        } else {
            return redirect('/dashboard/ads')->with(['msg' => '广告创建失败', 'code' => 500]);
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
            return abort(404);
        }

        $data = Ad::findOrFail($id);
        return view('dashboard.ads.edit', ['data' => $data]);
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
        $messages = [
            'title.required' => '请输入广告标题',
            'path.required' => '请选择要上传的图片',
            'type.required' => '请选择广告类型',
        ];
        $this->validate($request, [
            'title' => 'required|max:255',
            'path' => 'required|max:255',
            'type' => 'required',
        ], $messages);

        $savePath = "";
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            if (!starts_with($file->getMimeType(), 'image')) {
                return abort(500, '上传文件类型错误');
            }
            if (!$file->isValid()) {
                return abort(500, '上传文件出错');
            }
            $newFileName = md5(time() . rand(0, 10000)) . '.' . $file->getClientOriginalExtension();
            $savePath = date('Ym', time()) . '/' . $newFileName;
            $bytes = Storage::put(
                $savePath,
                file_get_contents($file->getRealPath())
            );
            if (!Storage::exists($savePath)) {
                return abort(500, '保存文件出错');
            }
        }
        $item = Ad::findOrFail($id);
        $item->user_id = Auth::user()->id;
        $item->title = $request->title;
        $item->url = $request->url;
        $item->sort = $request->sort ? $request->sort : 1;
        $item->type = $request->type;
        if (!empty($savePath)) {
            $item->path = $savePath;
        }
        if ($item->save()) {
            return redirect('/dashboard/ads')->with(['msg' => '广告更新成功', 'code' => 200]);
        } else {
            return redirect('/dashboard/ads')->with(['msg' => '广告更新失败', 'code' => 500]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (empty($id)) {
            return abort(404);
        }

        $data = Ad::findOrFail($id);
        if (Ad::destroy($id)) {
            Storage::delete($data->path);
            return response()->json(['msg' => '删除成功', 'code' => 200]);
        } else {
            return response()->json(['msg' => '删除失败', 'code' => 500]);
        }
    }
    //删除图片
    public function delete(Request $request)
    {
        $id = $request->id;
        if (empty($id)) {
            return abort(404);
        }
        $path = $request->key;
        $result = DB::table('ads')->where(['id' => $id])->update(['path' =>'']);
        if ($result) {
            Storage::delete($path);
            return response()->json(['status' => true, 'msg' => '删除成功']);
        }
        return abort(500, '删除失败，没有权限或者图片已经删除');
    }
}
