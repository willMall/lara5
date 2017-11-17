<!DOCTYPE html>
<html lang="zh-cmn-Hans">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <title>商城首页</title>
        <link rel="stylesheet" href="//res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
        <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
        <link rel="stylesheet" href="/css/app.css"/>
    </head>
    <body ontouchstart>
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
        <!-- body -->
        <div class='weui-content'>
            <!--顶部轮播-->
            <div class="swiper-container swiper-banner">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><a href="#pro_info.html"><img src="/images/upload/banner_1.jpg" /></a></div>
                    <div class="swiper-slide"><a href="#pro_list.html"><img src="/images/upload/banner_2.jpg" /></a></div>
                    <div class="swiper-slide"><a href="#pro_info.html"><img src="/images/upload/banner_3.jpg" /></a></div>
                    <div class="swiper-slide"><a href="#pro_list.html"><img src="/images/upload/banner_4.jpg" /></a></div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <!--图标分类-->
            <div class="weui-flex wy-iconlist-box">
                <div class="weui-flex__item"><a href="#pro_list.html" class="wy-links-iconlist"><div class="img"><img src="/images/upload/icon-link1.png"></div><p>精选推荐</p></a></div>
                <div class="weui-flex__item"><a href="#pro_list.html" class="wy-links-iconlist"><div class="img"><img src="/images/upload/icon-link2.png"></div><p>特卖专场</p></a></div>
                <div class="weui-flex__item"><a href="/member/order" class="wy-links-iconlist"><div class="img"><img src="/images/upload/icon-link3.png"></div><p>订单管理</p></a></div>
                <div class="weui-flex__item"><a href="#Settled_in.html" class="wy-links-iconlist"><div class="img"><img src="/images/upload/icon-link4.png"></div><p>商家入驻</p></a></div>
            </div>
            <!--商城公告-->
            <div class="wy-ind-news">
                <i class="news-icon-laba"></i>
                <div class="swiper-container swiper-news">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><a href="#news_info.html">天利和亮相临汾国际大气污染防治技术展览会</a></div>
                        <div class="swiper-slide"><a href="#news_info.html">天利和安全环保受邀参加东营市环境监测与治理大会</a></div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <a href="#news_list.html" class="newsmore"><i class="news-icon-more"></i></a>
            </div>
            <!--精选推荐-->
            <div class="wy-Module">
                <div class="wy-Module-tit"><span>精选推荐</span></div>
                <div class="wy-Module-con">
                    <div class="swiper-container swiper-jingxuan" style="padding-top:34px;">
                        <div class="swiper-wrapper">
@foreach ($tops as $top)
                            <div class="swiper-slide"><a href="/item/{{$top->id}}"><img src="{{$top->thumb?'/storage/'.$top->thumb:'/images/nofiles.png'}}" /></a></div>
@endforeach
                        </div>
                        <div class="swiper-pagination jingxuan-pagination"></div>
                    </div>
                </div>
            </div>
            <!--特卖推荐-->
            <!-- <div class="wy-Module">
                <div class="wy-Module-tit"><span>特卖推荐</span></div>
                <div class="wy-Module-con">
                    <div class="swiper-container swiper-jiushui" style="padding-top:34px;">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide"><a href="#pro_info.html"><img src="/images/upload/jingxuan1.jpg" /></a></div>
                            <div class="swiper-slide"><a href="#pro_info.html"><img src="/images/upload/jingxuan2.jpg" /></a></div>
                            <div class="swiper-slide"><a href="#pro_info.html"><img src="/images/upload/jingxuan3.jpg" /></a></div>
                            <div class="swiper-slide"><a href="#pro_info.html"><img src="/images/upload/jingxuan4.jpg" /></a></div>
                            <div class="swiper-slide"><a href="#pro_info.html"><img src="/images/upload/jingxuan5.jpg" /></a></div>
                            <div class="swiper-slide"><a href="#pro_info.html"><img src="/images/upload/jingxuan1.jpg" /></a></div>
                            <div class="swiper-slide"><a href="#pro_info.html"><img src="/images/upload/jingxuan1.jpg" /></a></div>
                            <div class="swiper-slide"><a href="#pro_info.html"><img src="/images/upload/jingxuan2.jpg" /></a></div>
                            <div class="swiper-slide"><a href="#pro_info.html"><img src="/images/upload/jingxuan3.jpg" /></a></div>
                            <div class="swiper-slide"><a href="#pro_info.html"><img src="/images/upload/jingxuan4.jpg" /></a></div>
                            <div class="swiper-slide"><a href="#pro_info.html"><img src="/images/upload/jingxuan5.jpg" /></a></div>
                            <div class="swiper-slide"><a href="#pro_info.html"><img src="/images/upload/jingxuan1.jpg" /></a></div>
                        </div>
                        <div class="swiper-pagination jingxuan-pagination"></div>
                    </div>
                </div>
            </div> -->
            <!--首页推荐-->
            <div class="wy-Module">
                <div class="wy-Module-tit-line"><span>首页推荐</span></div>
                <div class="wy-Module-con">
                    <ul class="wy-pro-list clear">
@foreach ($items as $item)
                        <li>
                            <a href="/item/{{$item->id}}">
                                <div class="proimg"><img src="{{$item->thumb?'/storage/'.$item->thumb:'/images/nofiles.png'}}"></div>
                                <div class="protxt">
                                    <div class="name">{{$item->name}}</div>
                                    <div class="wy-pro-pri">¥<span>{{$item->price/100}}</span></div>
                                </div>
                            </a>
                        </li>
@endforeach
                    </ul>
                    <!-- <div class="morelinks"><a href="#pro_list.html">查看更多 >></a></div> -->
                </div>
            </div>
        </div>
        <!-- /body -->
        <!-- footer -->
        <div class="foot-black"></div>
        <div class="weui-tabbar wy-foot-menu">
            <a href="/app" class="weui-tabbar__item weui-bar__item--on">
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
            <a href="/member" class="weui-tabbar__item">
                <div class="weui-tabbar__icon foot-menu-member"></div>
                <p class="weui-tabbar__label">会员</p>
            </a>
        </div>
        <!-- /footer -->
        <script src="//cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/fastclick/1.0.6/fastclick.min.js"></script>
        <script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
        <script src="//cdn.bootcss.com/Swiper/3.3.1/js/swiper.min.js"></script>
        <script>
            $(function() {
                FastClick.attach(document.body);
                $(".swiper-banner").swiper({
                    loop: true,
                    autoplay: 3000
                });
                $(".swiper-news").swiper({
                    loop: true,
                    direction: 'vertical',
                    paginationHide :true,
                    autoplay: 30000
                });
                $(".swiper-jingxuan").swiper({
                    pagination: '.swiper-pagination',
                    loop: true,
                    paginationType:'fraction',
                    slidesPerView:3,
                    paginationClickable: true,
                    spaceBetween: 2
                });
                $(".swiper-jiushui").swiper({
                    pagination: '.swiper-pagination',
                    paginationType:'fraction',
                    loop: true,
                    slidesPerView:3,
                    slidesPerColumn: 2,
                    paginationClickable: true,
                    spaceBetween:2
                });
            });
        </script>
    </body>
</html>