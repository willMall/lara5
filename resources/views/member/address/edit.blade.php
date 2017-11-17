<!DOCTYPE html>
<html lang="zh-cmn-Hans">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <title>地址管理</title>
        <link rel="stylesheet" href="//res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
        <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
        <link rel="stylesheet" href="/css/app.css"/>
    </head>
    <body ontouchstart>
        <div class="weui-content">
            <div class="weui-cells weui-cells_form wy-address-edit">
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label wy-lab">收货人</label></div>
                    <div class="weui-cell__bd"><input class="weui-input" name="name" value="{{$address->name}}" type="text" pattern="*" placeholder="收货人姓名"></div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label wy-lab">手机号</label></div>
                    <div class="weui-cell__bd"><input class="weui-input" name="mobile" value="{{$address->mobile}}" type="number" pattern="[0-9]*" placeholder="联系手机"></div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label for="name" class="weui-label wy-lab">所在地区</label></div>
                    <div class="weui-cell__bd"><input class="weui-input" id="address" type="text" value="陕西省 西安市 雁塔区" readonly="" data-code="420106" data-codes="420000,420100,420106"></div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label wy-lab">详细地址</label></div>
                    <div class="weui-cell__bd">
                        <textarea class="weui-textarea" name="address" placeholder="详细地址">{{$address->address}}</textarea>
                    </div>
                </div>
                <div class="weui-cell weui-cell_switch">
                    <div class="weui-cell__bd">设为默认地址</div>
                    <div class="weui-cell__ft"><input class="weui-switch" type="checkbox"{{$address->default?'checked':''}}></div>
                </div>
            </div>

            <div class="weui-btn-area">
                <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips">保存此地址</a>
                <a href="javascript:;" class="weui-btn weui-btn_warn">删除此地址</a>
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
        <!-- /footer -->
        <script src="//cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
        <script src="/js/city-picker.min.js"></script>
        <script>
            $("#address").cityPicker({
                title: "选择省市区",
                onChange: function (picker, values, displayValues) {
                    console.log(values, displayValues);
                }
            });
        </script>
    </body>
</html>