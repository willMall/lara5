<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="zh-cmn-Hans">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <title>订单确认</title>
        <link rel="stylesheet" href="//res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
        <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
        <link rel="stylesheet" href="/css/app.css"/>
    </head>
    <body ontouchstart>
        <div class="weui-content" style="background-color: #fff;">
            <div class="weui-tab">
                <div class="weui-tab__bd proinfo-tab-con">
                    <div class="weui-tab__bd-item weui-tab__bd-item--active" id="order">
                        <div class="weui-panel weui-panel_access">
                            <div class="weui-panel__hd">
                                <span>单号：<b>{{$order->uuid}}</b></span>
                                <span class="ord-status-txt-ts fr">{{$order->status==0?'未支付':'已支付'}}</span>
                            </div>
                            <div class="weui-media-box__bd pd-10">
@foreach ($details as $item)
                                <div class="weui-media-box_appmsg ord-pro-list">
                                    <div class="weui-media-box__hd"><a href="pro_info.html"><img class="weui-media-box__thumb" src="{{$item->thumb?'/storage/'.$item->thumb:'/images/nofiles.png'}}" alt=""></a></div>
                                    <div class="weui-media-box__bd">
                                        <h1 class="weui-media-box__desc"><a href="/item/{{$item->item_id}}" class="ord-pro-link">{{$item->name}}</a></h1>
                                        <div class="clear mg-t-10">
                                            <div class="wy-pro-pri fl">¥<em class="num font-15">{{$item->price/100}}</em></div>
                                            <div class="pro-amount fr"><span class="font-13">数量×<em class="name">{{$item->qty}}</em></span></div>
                                        </div>
                                    </div>
                                </div>
@endforeach
                                <div class="ord-statistics">
                                    <span>共<em class="num">{{count($details)}}</em>件商品，</span>
                                    <span class="wy-pro-pri">总金额：¥<em class="num font-15">{{$order->price/100}}</em></span>
                                </div>

                            </div>
                            <div class="weui-cells weui-cells_form wy-address-edit" id="addr">
                                <div class="weui-cell">
                                    <div class="weui-cell__hd"><label class="weui-label wy-lab">收货人</label></div>
                                    <div class="weui-cell__bd"><input class="weui-input" type="text" id="name" name="name" required pattern="REG_NAME" placeholder="收货人姓名"></div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui-cell__hd"><label class="weui-label wy-lab">手机号</label></div>
                                    <div class="weui-cell__bd"><input class="weui-input" type="number" id="mobile" name="mobile" required pattern="REG_MOBILE" placeholder="请输入手机号码" emptyTips="请输入手机号码" notMatchTips="请输入正确的手机号"></div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui-cell__hd"><label class="weui-label wy-lab">所在地区</label></div>
                                    <div class="weui-cell__bd"><input class="weui-input" id="area" id="area" name="area" type="text" value="陕西省 西安市 雁塔区" readonly="" data-code="610113" data-codes="610000,610100,610113"></div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui-cell__hd"><label class="weui-label wy-lab">详细地址</label></div>
                                    <div class="weui-cell__bd">
                                        <textarea class="weui-textarea" id="address" name="address" required pattern="REG_ADDRESS" placeholder="收货人详细地址"></textarea>
                                    </div>
                                </div>
                                <div class="weui-cell weui-cell_switch">
                                    <div class="weui-cell__bd">设为默认地址</div>
                                    <div class="weui-cell__ft"><input class="weui-switch" type="checkbox" name="default" id="default"></div>
                                </div>
                            </div>
                            <div class="weui-panel__ft">
                                <div class="weui-cell weui-cell_access weui-cell_link oder-opt-btnbox">
                                    <a id="payment" class="weui-btn weui-btn_primary"" href="javascript:">支付</a>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="foot-black"></div>
            <div class="weui-tabbar wy-foot-menu">
                <a href="/app" class="weui-tabbar__item">
                    <div class="weui-tabbar__icon foot-menu-home"></div>
                    <p class="weui-tabbar__label">首页</p>
                </a>
                <a href="/category" class="weui-tabbar__item">
                    <div class="weui-tabbar__icon foot-menu-list"></div>
                    <p class="weui-tabbar__label">分类</p>
                </a>
                <a href="/cart" class="weui-tabbar__item">
                    <div class="weui-tabbar__icon foot-menu-cart"></div>
                    <p class="weui-tabbar__label">购物车</p>
                </a>
                <a href="/member" class="weui-tabbar__item weui-bar__item--on">
                    <div class="weui-tabbar__icon foot-menu-member"></div>
                    <p class="weui-tabbar__label">会员</p>
                </a>
            </div>
        </div>
        <!-- <script src="//cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script> -->
        <script type="text/javascript" src="//cdn.bootcss.com/zepto/1.2.0/zepto.min.js"></script>
        <script type="text/javascript" src="//res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
        <script type="text/javascript" src="//res.wx.qq.com/open/libs/weuijs/1.1.2/weui.min.js"></script>
        <script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
        <script type="text/javascript" src="/js/city-picker.min.js"></script>
        <script type="text/javascript">
            $(function(){
                $("#area").cityPicker({
                    title: "选择省市区",
                    onChange: function (picker, values, displayValues) {
                        // console.log(values, displayValues);
                    }
                });
                var regexp = {
                    regexp: {
                        NAME:/^\s*\S{2,10}\s*$/,
                        MOBILE:/^1[3|4|5|7|8][0-9]{9}$/,
                        ADDRESS:/^\s*\S{4,32}\s*$/
                    }
                };
                weui.form.checkIfBlur('#addr', regexp);
                document.querySelector('#payment').onclick = function () {
                    weui.form.validate('#addr', function (error) {
                        if (!error) {
                            var address = {};
                            address.name = $("#name").val();
                            address.mobile = $("#mobile").val();
                            address.address = $("#area").val()+' '+$("#address").val();
                            address.default = $('#default').is(":checked");
                            $.post('/member/address', { _token:'{{csrf_token()}}', order_id: '{{$order->uuid}}', address: address }, function(response){
                                wx.config({!!$app->jssdk->buildConfig(['chooseWXPay'])!!});
                                wx.ready(function(){
                                    document.querySelector('#payment').onclick = function () {
                                        wx.chooseWXPay({
                                            timestamp: {{$config['timestamp']}},
                                            nonceStr: '{{$config['nonceStr']}}',
                                            package: '{{$config['package']}}',
                                            signType: '{{$config['signType']}}',
                                            paySign: '{{$config['paySign']}}',
                                            success: function (res) {
                                                window.location.href="/member/order";
                                            }
                                        });
                                    };
                                });
                            },'json')
                        }
                    }, regexp);
                }
            });
        </script>
    </body>
</html>