<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenID extends Model
{
    protected $table = 'openids';
    protected $fillable = ['openid'];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'openid_id');
    }

    /**
     * 获得此微信用户的收货地址。
     */
    public function addresses()
    {
        return $this->hasMany('App\Models\Address', 'openid_id');
    }

    /**
     * 获得微信用户的订单。
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'openid_id');
    }
}
