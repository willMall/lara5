<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $query = User::where('status', 1);
        if (!empty($keyword)) {
            $query->where(DB::raw("CONCAT(`email`,`mobile`)"), 'LIKE', '%' . $keyword . '%');
        }
        $items = $query->orderBy('id', 'desc')->paginate();
        foreach ($items as $key => $value) {
            $rolename = User::find($value->id)->getRoleNames();
            $roleids = DB::table('model_has_roles')->where('model_id', $value->id)->pluck('role_id');
            $value->roleids = $roleids;
            $value->rolename = $rolename ? $rolename : '';
        }
        return view('dashboard.user.index', ['items' => $items, 'roleList' => Role::get()]);
    }
    public function userroleadd(Request $request)
    {
        $id = $request->id;
        $rolename = $request->rolename;
        if (empty($id)) {
            return abort(404);
        }

        $user = User::findOrFail($id);
        DB::transaction(function () use ($rolename, $user) {
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();
            if (!empty($rolename)) {
                $user->assignRole($rolename);
            }
        });
        return response()->json(['msg' => '角色分配成功', 'code' => 200]);
    }
    public function roleadd(Request $request)
    {
        $messages = [
            'name.required' => '请输入角色名称',
            'name.max' => '角色名称最长 :max 个字符',
        ];
        $this->validate($request, [
            'name' => 'required|max:255',
        ], $messages);
        $rolename = $request->name;
        $data = Role::where('name', $rolename)->first();
        if (!empty($data)) {
            return response()->json(['msg' => '该角色名称已经存在', 'code' => 500]);
        }
        $re = Role::create(['name' => $rolename]);
        if ($re) {
            return response()->json(['msg' => '角色添加成功', 'code' => 200]);
        } else {
            return response()->json(['msg' => '角色添加失败', 'code' => 500]);
        }
    }
}
