<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="zh-cmn-Hans">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <title>订单中心</title>
        <link rel="stylesheet" href="//res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
        <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
        <link rel="stylesheet" href="/css/app.css"/>
    </head>
    <body ontouchstart>
        <div class="weui-content" style="background-color: #fff;">
            <div class="weui-tab">
                <div class="weui-tab__bd proinfo-tab-con">
                    <div class="weui-tab__bd-item weui-tab__bd-item--active" id="order" v-cloak>
                        <div class="weui-loadmore weui-loadmore_line" v-if="empty">
                            <span class="weui-loadmore__tips">暂无订单</span>
                        </div>
                        <div class="weui-panel weui-panel_access" v-for="(order, index) in orders">
                            <div class="weui-panel__hd">
                                <span>单号：<b>@{{order.uuid}}</b></span>
                                <span class="ord-status-txt-ts fr">@{{order.status==0?'未支付':'已支付'}}</span>
                            </div>
                            <div class="weui-media-box__bd pd-10">
                                <div class="weui-media-box_appmsg ord-pro-list" v-for="item in order.details">
                                    <div class="weui-media-box__hd"><a href="pro_info.html"><img class="weui-media-box__thumb" v-bind:src="item.thumb?'/storage/' + item.thumb:'/images/nofiles.png'" alt=""></a></div>
                                    <div class="weui-media-box__bd">
                                        <h1 class="weui-media-box__desc"><a :href="'/item/'+item.item_id" class="ord-pro-link">@{{item.name}}</a></h1>
                                        <div class="clear mg-t-10">
                                            <div class="wy-pro-pri fl">¥<em class="num font-15">@{{item.price/100}}</em></div>
                                            <div class="pro-amount fr"><span class="font-13">数量×<em class="name">@{{item.qty}}</em></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ord-statistics">
                                    <span>共<em class="num">@{{order.details.length}}</em>件商品，</span>
                                    <span class="wy-pro-pri">总金额：¥<em class="num font-15">@{{order.price/100}}</em></span>
                                </div>
                                <div class="weui-panel__ft">
                                    <div class="weui-cell weui-cell_access weui-cell_link oder-opt-btnbox">
                                        <a :href="'/member/payment/?id='+order.uuid" class="ords-btn-com" v-if="order.status==0">重新支付</a>
                                        <a href="javascript:;" class="ords-btn-dele" v-else>付款完成</a>

                                    </div>    
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
        <script src="//cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/axios/0.16.2/axios.min.js"></script>
        <script src="//cdn.bootcss.com/vue/2.4.4/vue.js"></script>
        <script type="text/javascript">
            $(function(){
                var vm = new Vue({
                    el: '#order',
                    data: {
                        empty: false,
                        orders: []
                    },
                    mounted(){
                        axios.get("/member/order/api").then(response => {
                            this.orders = response.data;
                            this.empty = this.orders.length ? false : true;
                        }).catch(function (error) {
                            console.log("get data error...");
                        });
                    }
                })
            });
        </script>
    </body>
</html>