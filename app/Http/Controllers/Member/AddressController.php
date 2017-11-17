<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OpenID;
use App\Models\Address;
use App\Models\Order;

class AddressController extends Controller
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
        return view('member.address.index');
    }

    public function api()
    {
        $openid = OpenID::firstOrCreate(['openid' => $this->user->id]);
        return response()->json($openid->addresses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $address = $request->address;
        $address['default'] = ($address['default']=='true')?1:0;
        $openid = OpenID::firstOrCreate(['openid' => $this->user->id]);
        $address['openid_id'] = $openid->id;
        Address::create($address);
        Order::where('uuid', $request->order_id)->update(['name'=>$address['name'], 'mobile'=>$address['mobile'], 'address'=>$address['address']]);
        return response()->json(['status'=>'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $address = Address::findOrFail($id);
        return view('member.address.edit', ['address'=>$address]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
