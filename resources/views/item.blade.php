<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="zh-cmn-Hans">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <title>商品详情</title>
        <link rel="stylesheet" href="//res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
        <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
        <link rel="stylesheet" href="/css/app.css"/>
    </head>
    <body ontouchstart>
        <!-- body -->
        <div class='weui-content'>
            <div class="weui-tab">
                <div class="weui-tab__bd proinfo-tab-con">
                    <div id="tab1" class="weui-tab__bd-item weui-tab__bd-item--active">
                        <!--swiper-->
                        <div class="swiper-container swiper-zhutu">
                            <div class="swiper-wrapper">
@forelse ($attachments as $attachment)
                                <div class="swiper-slide"><img src="/storage/{{ $attachment->path }}" /></div>
@empty
                                <div class="swiper-slide"><img src="/images/nofiles.png" /></div>
@endforelse
                            </div>
                            <div class="swiper-pagination swiper-zhutu-pagination"></div>
                        </div>
                        <div class="wy-media-box-nomg weui-media-box_text">
                            <h4 class="wy-media-box__title">{{$item->name}}</h4>
                            <div class="wy-pro-pri mg-tb-5">¥<em class="num font-20">{{$item->price/100}}</em></div>
                            <p class="weui-media-box__desc">{{$item->name}}</p>
                        </div>
                        <div class="wy-media-box2 txtpd weui-media-box_text">
                            <div class="weui-media-box_appmsg">
                                <div class="weui-media-box__hd proinfo-txt-l"><span class="promotion-label-tit">运费</span></div>
                                <div class="weui-media-box__bd">
                                    <div class="promotion-message clear">
                                        <span class="promotion-item-text">免运费<!--<div class="wy-pro-pri">¥<span class="num">11.00</span></div>--></span>
                                    </div>
                                </div>
                            </div>
                            <div class="weui-media-box_appmsg">
                                <div class="weui-media-box__hd proinfo-txt-l"><span class="promotion-label-tit">提示</span></div>
                                <div class="weui-media-box__bd">
                                    <div class="promotion-message clear">
                                        <span class="promotion-item-text"><p class="txt-color-ml">支持7天无理由退换货</p></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pro-detail">
                            {!!$item->details!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <span id="tophovertree" title="返回顶部"></span>
        <!-- /body -->
        <!-- footer -->
        <div class="foot-black"></div>
        <div class="weui-tabbar wy-foot-menu">
            
            <a id="cart" href="javascript:;" class="weui-tabbar__item yellow-color open-popup" data-target="#join_cart">
                <p class="promotion-foot-menu-label">加入购物车</p>
            </a>
            <a id="buy" href="javascript:;" class="weui-tabbar__item red-color open-popup">
                <p class="promotion-foot-menu-label">立即购买</p>
            </a>
        </div>
        <div id="join_cart" class='weui-popup__container popup-bottom' style="z-index:600;">
            <div class="weui-popup__overlay" style="opacity:1;"></div>
            <div class="weui-popup__modal">
                <div class="modal-content">
                    <div class="weui-msg" style="padding-top:0;">
                        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
                        <div class="weui-msg__text-area">
                            <h2 class="weui-msg__title">成功加入购物车</h2>
                            <p class="weui-msg__desc">亲爱的用户，您的商品已成功加入购物车，为了保证您的商品快速送达，请您尽快到购物车结算。</p>
                        </div>
                        <div class="weui-msg__opr-area">
                            <p class="weui-btn-area">
                                <a href="/cart" class="weui-btn weui-btn_primary">去购物车结算</a>
                                <a href="javascript:;" class="weui-btn weui-btn_default close-popup">不，我再看看</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /footer -->
        <script src="//cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/fastclick/1.0.6/fastclick.min.js"></script>
        <script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
        <script src="//cdn.bootcss.com/Swiper/3.3.1/js/swiper.min.js"></script>
        <script>
            $(function(){
                var token = '{{csrf_token()}}';
                FastClick.attach(document.body);
                initTopHoverTree("tophov"+"ertree",30,10,10);
                $(".swiper-zhutu").swiper({
                    loop: true,
                    paginationType:'fraction',
                    autoplay:5000
                });

                document.querySelector('#cart').addEventListener('click', function () {
                    $.post('/cart', { _token:token, item_id: {{$item->id}} }, function(response){
                        console.log('ok')
                    },'json')
                });
                document.querySelector('#buy').addEventListener('click', function () {
                    $.post('/cart', { _token:token, item_id: {{$item->id}} }, function(response){
                        window.location.href="/cart/";
                    },'json')
                });

                $(document).on("open", ".weui-popup-modal", function() {
                    console.log("open popup");
                }).on("close", ".weui-popup-modal", function() {
                    console.log("close popup");
                });

                function initTopHoverTree(hvtid, times, right, bottom) {
                    $("#" + hvtid).css("right", right).css("bottmo", bottom);
                    $("#" + hvtid).on("click", function() { goTopHovetree(times); })
                    $(window).scroll(function() {
                        if ($(window).scrollTop() > 268) {
                            $("#" + hvtid).fadeIn(100);
                        } else {
                            $("#" + hvtid).fadeOut(100);
                        }
                    });
                }
                //返回顶部动画
                function goTopHovetree(times) {
                    if (!!!times) {
                        $(window).scrollTop(0);
                        return;
                    }
                    var sh = $('body').scrollTop();
                    var inter = 13.333;
                    var forCount = Math.ceil(times / inter);
                    var stepL = Math.ceil(sh / forCount);
                    var timeId = null;

                    function aniHovertree() {
                        !!timeId && clearTimeout(timeId);
                        timeId = null;
                        //console.log($('body').scrollTop());
                        if ($('body').scrollTop() <= 0 || forCount <= 0) {
                            $('body').scrollTop(0);
                            return;
                        }
                        forCount--;
                        sh -= stepL;
                        $('body').scrollTop(sh);
                        timeId = setTimeout(function() { aniHovertree(); }, inter);
                    }
                    aniHovertree();
                }
            });
        </script>
    </body>
</html>