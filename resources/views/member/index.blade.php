<!DOCTYPE html>
<html lang="zh-cmn-Hans">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <title>会员中心</title>
        <link rel="stylesheet" href="//res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
        <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
        <link rel="stylesheet" href="/css/app.css"/>
    </head>
    <body ontouchstart>
        <!-- body -->
        <div class='weui-content'>
            <div class="wy-center-top">
                <div class="weui-media-box weui-media-box_appmsg">
                    <div class="weui-media-box__hd"><img class="weui-media-box__thumb radius" src="{{$user->getAvatar()}}" alt=""></div>
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title user-name">{{$user->getName()}}</h4>
                        <p class="user-grade">等级：普通会员</p>
                        <!-- <p class="user-integral">账户余额：<em class="num">500.0</em>元</p> -->
                    </div>
                </div>
            </div>

            <!-- <div class="weui-panel weui-panel_access">
                <div class="weui-panel__hd">
                    <a href="all_orders.html" class="weui-cell weui-cell_access center-alloder">
                        <div class="weui-cell__bd wy-cell">
                            <div class="weui-cell__hd"><img src="/images/center-icon-order-all.png" alt="" class="center-list-icon"></div>
                            <div class="weui-cell__bd weui-cell_primary"><p class="center-list-txt">全部订单</p></div>
                        </div>
                        <span class="weui-cell__ft"></span>
                    </a>   
                </div>
                <div class="weui-panel__bd">
                    <div class="weui-flex">
                        <div class="weui-flex__item">
                            <a href="all_orders.html" class="center-ordersModule">
                                <span class="weui-badge" style="position: absolute;top:5px;right:10px; font-size:10px;">2</span>
                                <div class="imgicon"><img src="/images/center-icon-order-dfk.png" /></div>
                                <div class="name">待付款</div>
                            </a>
                        </div>
                        <div class="weui-flex__item">
                            <a href="all_orders.html" class="center-ordersModule">
                                <span class="weui-badge" style="position: absolute;top:5px;right:10px; font-size:10px;">1</span>
                                <div class="imgicon"><img src="/images/center-icon-order-dfh.png" /></div>
                                <div class="name">待发货</div>
                            </a>
                        </div>
                        <div class="weui-flex__item">
                            <a href="all_orders.html" class="center-ordersModule">
                                <div class="imgicon"><img src="/images/center-icon-order-dsh.png" /></div>
                                <div class="name">待收货</div>
                            </a>
                        </div>
                        <div class="weui-flex__item">
                            <a href="orders.html" class="center-ordersModule">
                                <span class="weui-badge" style="position: absolute;top:5px;right:10px; font-size:10px;">2</span>
                                <div class="imgicon"><img src="/images/center-icon-order-dpj.png" /></div>
                                <div class="name">待评价</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="weui-panel">
                <div class="weui-panel__bd">
                    <div class="weui-media-box weui-media-box_small-appmsg">
                        <div class="weui-cells">
                            <a class="weui-cell weui-cell_access" href="/member/order">
                                <div class="weui-cell__hd">
                                    <img src="/images/center-icon-jyjl.png" alt="" class="center-list-icon">
                                </div>
                                <div class="weui-cell__bd weui-cell_primary">
                                    <p class="center-list-txt">订单中心</p>
                                </div>
                                <span class="weui-cell__ft"></span>
                            </a>
                            <a class="weui-cell weui-cell_access" href="#/member/fav">
                                <div class="weui-cell__hd">
                                    <img src="/images/center-icon-sc.png" alt="" class="center-list-icon">
                                </div>
                                <div class="weui-cell__bd weui-cell_primary">
                                    <p class="center-list-txt">我的收藏</p>
                                </div>
                                <span class="weui-cell__ft"></span>
                            </a>
                            <a class="weui-cell weui-cell_access" href="/member/address">
                                <div class="weui-cell__hd">
                                    <img src="/images/center-icon-dz.png" alt="" class="center-list-icon">
                                </div>
                                <div class="weui-cell__bd weui-cell_primary">
                                    <p class="center-list-txt">地址管理</p>
                                </div>
                                <span class="weui-cell__ft"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /body -->

        <!-- footer -->
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
        <script src="//cdn.bootcss.com/fastclick/1.0.6/fastclick.min.js"></script>
        <!-- <script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script> -->
        <script type="text/javascript">
            $(function(){
                FastClick.attach(document.body);
            });
        </script>
    </body>
</html>