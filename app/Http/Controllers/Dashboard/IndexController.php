<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('dashboard.index');
    }
        public function password()
    {
        return view('dashboard.password');
    }

    public function update(Request $request)
    {
        $messages = [
            'oldpassword.required' => '请输入原密码',
            'password.min' => '新密码长度最少 :min 个字符',
            'password_confirmation.min' => '确认密码长度最少 :min 个字符',
            'password.confirmed' => '两次密码不一致',
        ];
        $this->validate($request, [
            'oldpassword'=>'required',
            'password'=>'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ], $messages);
        $user = \Auth::user();
        if (\Hash::check($request->oldpassword, $user->password)) {
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect('dashboard.password')->with('msg', '修改成功');
        }
        return redirect('dashboard.password')->with('msg', '修改失败，原密码错误');
    }
}
