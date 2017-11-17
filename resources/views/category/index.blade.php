<!DOCTYPE html>
<html lang="zh-cmn-Hans">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <title>商城分类</title>
        <link rel="stylesheet" href="//res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
        <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
        <link rel="stylesheet" href="/css/app.css"/>
    </head>
    <body ontouchstart>
        <!-- body -->
        <div class="wy-content" id="category">
            <div class="category-top">
                <header class='weui-header'>
                    <div class="weui-search-bar" id="searchBar">
                        <form class="weui-search-bar__form">
                            <div class="weui-search-bar__box">
                                <i class="weui-icon-search"></i>
                                <input type="search" class="weui-search-bar__input" id="searchInput" placeholder="搜索您想要的商品" required>
                                <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
                            </div>
                            <label class="weui-search-bar__label" id="searchText" style="transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);">
                                <i class="weui-icon-search"></i>
                                <span>搜索您想要的商品</span>
                            </label>
                        </form>
                        <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel">取消</a>
                    </div>
                </header>
            </div>
            <aside>
                <div class="menu-left scrollbar-none" id="sidebar">
                    <ul>
                        <li v-for="(category, index) in categories" @click="getItems(index)" :class="{active: index==0}">@{{category.name.substring(0,4)}}</li>
                    </ul>
                </div>
            </aside>

            <section class="menu-right padding-all j-content">
                <!-- <h5>酒水食品1</h5> -->
                <ul>
                    <div class="weui-loadmore weui-loadmore_line" v-if="items.length==0">
                        <span class="weui-loadmore__tips">暂无商品</span>
                    </div>
                    <li class="w-3" v-for="(item, index) in items">
                        <a :href="'/item/'+item.id"></a>
                        <img :src="item.thumb?'/storage/' + item.thumb:'/images/nofiles.png'">
                        <span>@{{item.name}}</span>
                    </li>
                </ul>
            </section>
        </div>
        <div class="foot-black"></div>
        <div class="weui-tabbar wy-foot-menu">
            <a href="/app" class="weui-tabbar__item">
                <div class="weui-tabbar__icon foot-menu-home"></div>
                <p class="weui-tabbar__label">首页</p>
            </a>
            <a href="/category" class="weui-tabbar__item weui-bar__item--on">
                <div class="weui-tabbar__icon foot-menu-list"></div>
                <p class="weui-tabbar__label">分类</p>
            </a>
            <a href="/cart" class="weui-tabbar__item">
                <div class="weui-tabbar__icon foot-menu-cart"></div>
                <p class="weui-tabbar__label">购物车</p>
            </a>
            <a href="/member" class="weui-tabbar__item">
                <div class="weui-tabbar__icon foot-menu-member"></div>
                <p class="weui-tabbar__label">会员</p>
            </a>
        </div>
        <script src="//cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
        <script src="//cdn.bootcss.com/axios/0.16.2/axios.min.js"></script>
        <script src="//cdn.bootcss.com/vue/2.4.4/vue.js"></script>
        <script type="text/javascript">
            $(function(){
                var cate = new Vue({
                    el: '#category',
                    data: {
                        categories:{!!$categories!!},
                        items:[]
                    },
                    mounted(){
                        $('#sidebar ul li').click(function(){
                            $(this).addClass('active').siblings('li').removeClass('active');
                            var index = $(this).index();
                            $('.j-content').eq(index).show().siblings('.j-content').hide();
                        })
                        axios.get("/category/api/"+this.categories[0].id).then(response => {
                            this.items = response.data
                        }).catch(function (error) {
                            console.log("get data error...");
                        });
                    },
                    methods: {
                        getItems:function(index){
                            console.log();
                            axios.get("/category/api/"+cate.categories[index].id).then(response => {
                                this.items = response.data
                            }).catch(function (error) {
                                console.log("get data error...");
                            });
                        },
                    }
                })
            });
        </script>
    </body>
</html>