<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ramsey\Uuid\Uuid;
use App\Models\Order;
use App\Models\OpenID;
use ShoppingCart;

class OrderController extends Controller
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
        return view('member.order.index');
    }

    public function api(Request $request)
    {
        $openid = OpenID::firstOrCreate(['openid' => $this->user->id]);
        $orders = $openid->orders()->orderBy('id', 'desc')->take(10)->with('details')->get();
        $result = [];
        foreach ($orders as $key => $order) {
            $result[$key]['uuid'] = $order->uuid;
            $result[$key]['status'] = $order->status;
            $result[$key]['price'] = $order->price;
            $result[$key]['details'] = $order->details;
        }
        return response()->json($result);
    }
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $uuid = Uuid::uuid1()->getHex();
        $ids = [];
        $raws = [];
        $details = [];
        foreach ($request->items as $item) {
            $ids[] = $item['id'];
            $raws[] = $item['raw_id'];
        }
        $collections = \DB::table('items')->whereIn('id', $ids)->get();
        $agents = $collections->groupBy('user_id');
        $items = $collections->keyBy('id');
        // 计算购物车总价格
        $total = 0;
        foreach ($request->items as $item) {
            $total += $items[$item['id']]->price * $item['qty'];
            $item_index[$item['id']]=$item['qty'];
        }
        $openid = OpenID::firstOrCreate(['openid' => $this->user->id]);

        // 循环生成订单
        foreach ($agents as $user_id => $agent) {
            // 拆分生成订单
            $order = new Order;
            $order->user_id = $user_id;
            $order->uuid = $uuid;
            $order->sub_uuid = Uuid::uuid1()->getHex();
            $order->openid_id = $openid->id;
            $order->price = $total;
            $order->save();
            // 保存到订单详情
            foreach ($items as $value) {
                if ($value->user_id == $user_id) {
                    $details[] = ['order_id'=>$order->id, 'item_id'=>$value->id, 'name'=>$value->name, 'thumb'=>$value->thumb,'qty'=>$item_index[$value->id], 'price'=>$value->price, 'created_at'=>date('Y-m-d H:i:s', time()), 'updated_at'=>date('Y-m-d H:i:s', time())];
                }
            }
            \DB::table('order_details')->insert($details);
            unset($details);
        }
        // 删除购物车商品
        foreach ($raws as $raw) {
            ShoppingCart::remove($raw);
        }
        return response()->json(['uuid'=>$uuid]);
    }
}
