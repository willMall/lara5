<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Auth;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = \DB::table('notices');
        $query->join('users', 'users.id', '=', 'notices.user_id');
        $items = $query->select('notices.*', 'users.name as username')->orderBy('id', 'desc')->paginate();
        return view('dashboard.notice.index', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.notice.create');
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
            'title.required' => '请输入标题',
            'details.required' => '请选择要上传的图片',
        ];
        $this->validate($request, [
            'title' => 'required|max:255',
            'details' => 'required',
        ], $messages);

        $item = new Notice;
        $item->user_id = Auth::user()->id;
        $item->title = $request->title;
        $item->details = $request->details;
        if ($item->save()) {
            return redirect('/dashboard/notice')->with(['msg' => '通知创建成功', 'code' => 200]);
        } else {
            return redirect('/dashboard/notice')->with(['msg' => '通知创建失败', 'code' => 500]);
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

        $data = Notice::findOrFail($id);
        return view('dashboard.notice.show', ['data' => $data]);
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

        $data = Notice::findOrFail($id);
        return view('dashboard.notice.edit', ['data' => $data]);
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
        if (empty($id)) {
            return abort(404);
        }
        $messages = [
            'title.required' => '请输入标题',
            'details.required' => '请选择要上传的图片',
        ];
        $this->validate($request, [
            'title' => 'required|max:255',
            'details' => 'required',
        ], $messages);

        $item = Notice::findOrFail($id);
        $item->user_id = Auth::user()->id;
        $item->title = $request->title;
        $item->details = $request->details;
        if ($item->save()) {
            return redirect('/dashboard/notice')->with(['msg' => '通知更新成功', 'code' => 200]);
        } else {
            return redirect('/dashboard/notice')->with(['msg' => '通知更新失败', 'code' => 500]);
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

        if (Notice::destroy($id)) {
            return response()->json(['msg' => '删除成功', 'code' => 200]);
        } else {
            return response()->json(['msg' => '删除失败', 'code' => 500]);
        }
    }
}
