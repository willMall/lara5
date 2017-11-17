<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;
use Storage;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        if (!$request->hasFile('files')) {
            return abort(500, '上传文件为空');
        }
        $file = $request->file('files');
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
        switch ($request->own) {
            case 1:
                $msg = $this->items($request->type, $request->id, $savePath);
                break;
        }
        return $msg;
    }

    public function delete(Request $request)
    {
        $path = $request->key;
        $attachment = DB::table('attachments')->where(['user_id' => Auth::user()->id, 'path' => $path])->first();
        $thumd = DB::table('attachments')->where(['own' => '1', 'own_id' => $attachment->own_id, 'type' => 'files'])->where('id', '!=', $attachment->id)->first();
        $items = \App\Models\Item::where('thumb', '=', $path)->first();
        if (!empty($items)) {
            $items->thumb = !empty($thumd) ? $thumd->path : '';
            $items->save();
        }
        $result = DB::table('attachments')->where(['user_id' => Auth::user()->id, 'path' => $path])->delete();
        if ($result) {
            Storage::delete($path);
            return response()->json(['status' => true, 'msg' => '删除成功']);
        }
        return abort(500, '删除失败，没有权限或者图片已经删除');
    }

    private function items($type, $id, $path)
    {
        $user = Auth::user();
        $count = DB::table('attachments')->where(['own' => 1, 'own_id' => $id, 'type' => $type])->count();
        $max = 4;
        if ($count >= $max) {
            Storage::delete($path);
            return response()->json(['status' => false, 'msg' => '上传失败,图片不能超过 ' . $max . ' 个']);
        }
        $result = DB::table('attachments')->insert(['user_id' => $user->id, 'own' => 1, 'own_id' => $id, 'type' => $type, 'path' => $path]);
        if (!$result) {
            Storage::delete($path);
            return abort(500, '保存到服务器失败，请重新上传.');
        }
        if ($count == 0) {
            $items = \App\Models\Item::find($id);
            $items->thumb = $path;
            $items->save();
        }
        return response()->json(['status' => true, 'path' => $path, 'msg' => '上传成功']);
    }
}
