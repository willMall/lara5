<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OpenID;
use App\Models\User;

class IndexController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = session('wechat.oauth_user');
            return $next($request);
        });
    }

    public function index()
    {
        return view('member.index', ['user'=>$this->user]);
    }
}
