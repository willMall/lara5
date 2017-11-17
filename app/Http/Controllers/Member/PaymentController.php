<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ramsey\Uuid\Uuid;
use App\Models\Order;
use App\Models\Item;
use EasyWeChat\Factory;
use Carbon\Carbon;
use App\Models\OpenID;
use Log;

class PaymentController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = session('wechat.oauth_user');
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $uuid = $request->input('id');
        $sub_orders = Order::where('uuid', $uuid)->get()->pluck('id');
        $order = Order::where('uuid', $uuid)->firstOrFail();
        $details = \DB::table('order_details')->whereIn('order_id', $sub_orders)->get(['item_id', 'name', 'thumb', 'price', 'qty']);
        $openid = OpenID::where('openid', $this->user->id)->first();
        $address = $openid->addresses()->where('default', 1)->first();
        $config = config('wechat.official_account');
        $app = Factory::officialAccount($config);

        $options = config('wechat.payment');
        $payment = Factory::payment($options);
        $jssdk = $payment->jssdk;

        if (!$order->prepay_id) {
            $result = $this->prepay($order);
            if ($result['result_code'] == 'FAIL') {
                Log::info($result['err_code'] . ':' . $result['err_code_des']);
                return abort(404);
            }
            $config = $jssdk->sdkConfig($result['prepay_id']);
            // 保存预支付 ID 到订单记录。
            Order::where('uuid', $uuid)->update(['prepay_id' => $result['prepay_id']]);
            // $order->prepay_id = $result['prepay_id'];
            // $order->save();
            return view('member.payment.index', ['order' => $order, 'details' => $details, 'address' => $address, 'app' => $app, 'config' => $config]);
        }
        // 判断预支付 ID 时效性
        if (time() - strtotime($order->updated_at) < 7200) {
            $config = $jssdk->sdkConfig($order->prepay_id);
            return view('member.payment.index', ['order' => $order, 'details' => $details, 'address' => $address, 'app' => $app, 'config' => $config]);
        } else {
            return '订单失效';
        }
    }

    /**
     * 生成预支付订单
     *
     * @param  Order  $order
     * @return Prepay result
     */
    private function prepay($order)
    {
        $attributes = [
            'trade_type'   => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'         => time(),
            // 'detail'       => 'iPad mini 16G 白色',
            'out_trade_no' => $order->uuid,
            'total_fee'    => 1, //$total
            // 'notify_url'   => 'https://pay.weixin.qq.com/wxpay/pay.action',
            'openid' => $this->user->id,
        ];

        $app = Factory::payment(config('wechat.payment'));
        return $app->order->unify($attributes);
    }
}
