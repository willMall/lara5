<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EasyWeChat\Factory;
use App\Models\Order;
use Log;

class WechatController extends Controller
{
    public function notify()
    {
        $app = app('wechat.official_account');
        $app->server->push(function ($message) {
            return "欢迎关注 塑料宝";
        });
        return $app->server->serve();
    }

    public function payment(Request $request)
    {
        $app = Factory::payment(config('wechat.payment'));
        $response = $app->handlePaidNotify(function ($message, $fail) {
            $order = Order::where('uuid', $message['out_trade_no'])->first();
            if (!$order) {
                $fail('Order not exist.');
            }
            if ($order->status) {
                return true;
            }
            if ($message['result_code'] === 'SUCCESS') {
                Order::where('uuid', $message['out_trade_no'])->update(['status' => 1, 'updated_at' => date('Y-m-d H:i:s', time())]);
            }
            Log::info(json_encode($message));
            return true;
        });
        return $response;
    }
}
