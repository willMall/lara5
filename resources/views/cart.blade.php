<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="zh-cmn-Hans">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <title>购物车</title>
        <link rel="stylesheet" href="//res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
        <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
        <link rel="stylesheet" href="/css/app.css"/>
    </head>
    <body ontouchstart>

        <div id="cart" v-cloak>
            <div class="weui-content" style="background: #fff;">
                <div class="weui-loadmore weui-loadmore_line" v-if="items.length==0">
                    <span class="weui-loadmore__tips">购物车中暂无商品</span>
                </div>
                <div class="weui-panel weui-panel_access" v-for="(item, index) in items">
                    <!-- <div class="weui-panel__hd"><span>江苏蓝之蓝旗舰店</span><a href="javascript:;" class="wy-dele"></a></div> -->
                    <div class="weui-panel__bd">
                        <div class="weui-media-box_appmsg pd-10">
                            <div class="weui-media-box__hd check-w weui-cells_checkbox">
                                <label class="weui-check__label" v-bind:for="item.__raw_id">
                                    <div class="weui-cell__hd cat-check">
                                        <input type="checkbox" class="weui-check" name="item" v-bind:id="item.__raw_id" @click="selectGood(item)">
                                        <i class="weui-icon-checked"></i></div>
                                </label>
                            </div>
                            <div class="weui-media-box__hd"><a :href="'/item/'+item.id+'.html'"><img class="weui-media-box__thumb" v-bind:src="item.thumb?'/storage/' + item.thumb:'/images/nofiles.png'" alt=""></a></div>
                            <div class="weui-media-box__bd">
                                <h1 class="weui-media-box__desc"><a :href="'/item/'+item.id+'.html'" class="ord-pro-link">@{{item.name}}</a></h1>
                                <!-- <p class="weui-media-box__desc">规格：<span>红色</span>，<span>23</span></p> -->
                                <div class="clear mg-t-10">
                                    <div class="wy-pro-pri fl">¥<em class="num font-15">@{{item.price/100}}</em></div>
                                    <div class="pro-amount fr">
                                        <div class="Spinner">
                                            <a class="Decrease" href="javascript:void(0)" @click="changeQuentity(item,-1,index)"><i>-</i></a>
                                            <input class="Amount" v-bind:value=item.qty autocomplete="off" maxlength="3" readonly>
                                            <a class="Increase" href="javascript:void(0)" @click="changeQuentity(item,1)"><i>+</i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="foot-black"></div>
            <div class="weui-tabbar wy-foot-menu">
                <!-- <div class="npd cart-foot-check-item weui-cells_checkbox allselect">
                    <label class="weui-cell allsec-well weui-check__label" for="all"  @click="selectAll">
                        <div class="weui-cell__hd">
                            <input type="checkbox" class="weui-check">
                            <i class="weui-icon-checked"></i>
                        </div>
                        <div class="weui-cell__bd">
                            <p class="font-14">全选</p>
                        </div>
                    </label>
                </div> -->
                <div class="weui-tabbar__item  npd">
                    <p class="cart-total-txt">合计：<i>￥</i><em class="num font-16" id="zong1">@{{totalPrice | Currency}}</em></p>
                </div>
                <a href="javascript:;" class="red-color npd w-90 t-c">
                    <p class="promotion-foot-menu-label" @click="order">去结算</p>
                </a>
            </div>
        </div>
        <script type="text/javascript" src="//cdn.bootcss.com/zepto/1.2.0/zepto.min.js"></script>
        <script type="text/javascript" src="//res.wx.qq.com/open/libs/weuijs/1.1.2/weui.min.js"></script>
        <script src="//cdn.bootcss.com/axios/0.16.2/axios.min.js"></script>
        <script src="//cdn.bootcss.com/vue/2.4.4/vue.js"></script>
        <script type="text/javascript">
            $(function(){
                $('.weui-tabbar__item').on('click', function () {
                    $(this).addClass('weui-bar__item_on').siblings('.weui-bar__item_on').removeClass('weui-bar__item_on');
                });
                $(".allselect").click(function() {
                    if ($(this).find("input[name=all-sec]").prop("checked")) {
                        $("input[name=item]").each(function() {
                            $(this).prop("checked", true);
                        });

                    } else {
                        $("input[name=item]").each(function() {
                            if ($(this).prop("checked")) {
                                $(this).prop("checked", false);
                            } else {
                                $(this).prop("checked", true);
                            }
                        });

                    }
                });
                var cart = new Vue({
                    el: '#cart',
                    data: {
                        totalMoney:0,
                        items:[],
                        isSelectAll:false,
                        confirmDelete:false,
                        readyToDelIndex:-1
                    },
                    mounted(){
                        axios.get("/cart/api").then(response => {
                            this.items = response.data
                        }).catch(function (error) {
                            console.log("get data error...");
                        });
                    },
                    methods: {
                        order: function (event) {
                            $.post('/member/order', { _token:'{{csrf_token()}}', items: this.selected }, function(response){
                                window.location.href="/member/payment/?id="+response.uuid;
                            },'json')
                        },
                        selectGood:function(item,index){
                            if(item.isChecked == void 0){
                                this.$set(item,"isChecked",true)
                            } else {
                                item.isChecked = !item.isChecked;
                            }
                        },
                        selectAll:function(){
                            console.log('all')
                            this.isSelectAll = true;
                            this.items.forEach((item)=>{
                                item.isChecked = true;
                            });
                        },
                        unSelectAll:function(){
                            this.isSelectAll = false;
                            this.items.forEach((item)=>{
                                item.isChecked = false;
                            })
                        },
                        changeQuentity:function(item,val,_index){
                            if(item.qty == 1 && val == -1 ){
                                this.confirmDelete = true;
                                this.readyToDelIndex = _index;
                            } else {
                                item.qty += val;    
                            }
                        },
                    },
                    computed:{
                        totalPrice:function(){
                            var total = 0;
                            this.items.forEach(function(item){
                                if(item.isChecked){
                                    total += item.price * item.qty;
                                }
                            });
                            return total;
                        },
                        selected: function () {
                            var arr = [];
                            this.items.forEach(function(item){
                                if(item.isChecked){
                                    arr.push({'id':item.id,'qty':item.qty,'raw_id':item.__raw_id});
                                }
                            });
                            return arr;
                        }
                    },
                    filters:{
                        Currency:function(val){
                            return val/100 + " 元";
                        },
                    }
                })
            });
        </script>

    </body>
</html>