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
        <div class="weui-content" id="address" v-cloak>
            <div class="weui-panel address-box">
                <div class="weui-loadmore weui-loadmore_line" v-if="addresses.length==0">
                    <span class="weui-loadmore__tips" style="background: #f8f8f8">暂无地址</span>
                </div>
                <div class="weui-panel__bd" v-for="(address, index) in addresses">
                    <div class="weui-media-box weui-media-box_text address-list-box">
                        <a :href="'/member/address/'+address.id+'/edit'" class="address-edit"></a>
                        <h4 class="weui-media-box__title">
                            <span>@{{address.name}}</span>
                            <span>@{{address.mobile}}</span></h4>
                        <p class="weui-media-box__desc address-txt">@{{address.mobile}}</p>
                        <span class="default-add" v-if="address.default==1">默认地址</span>
                    </div>
                </div>
            </div>
            <div class="weui-btn-area">
                <a class="weui-btn weui-btn_primary" href="javascript:;" id="showTooltips">添加收货地址</a>
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
        <script src="//cdn.bootcss.com/axios/0.16.2/axios.min.js"></script>
        <script src="//cdn.bootcss.com/vue/2.4.4/vue.js"></script>
        <script>
                var cart = new Vue({
                    el: '#address',
                    data: {
                        addresses:[],
                        confirmDelete:false,
                        readyToDelIndex:-1
                    },
                    mounted(){
                        axios.get("/member/address/api").then(response => {
                            this.addresses = response.data
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
                    }
                })
        </script>
    </body>
</html>