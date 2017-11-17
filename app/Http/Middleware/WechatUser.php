<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\OpenID;

class WechatUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        OpenID::firstOrCreate(['openid' => session('wechat.oauth_user')->id]);
        return $next($request);
    }
}
