<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['openid_id', 'name', 'mobile', 'address', 'default'];
}
