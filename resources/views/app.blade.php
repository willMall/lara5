<!DOCTYPE html>
<html lang="zh-cmn-Hans">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <title>demo</title>
        <link rel="stylesheet" href="//res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
        <link rel="stylesheet" href="//weui.io/example.css"/>
    </head>
    <body ontouchstart>
        <div class="container" id="container">
            
<div class="page js_show">
    <div class="page__bd" style="height: 100%;">
        <div class="weui-tab">
            <div class="weui-tab__panel">

            </div>
            <div class="weui-tabbar">
                <a href="javascript:;" class="weui-tabbar__item">
                    <img src="/img/icon_tabbar.png" alt="" class="weui-tabbar__icon">
                    <p class="weui-tabbar__label">首页</p>
                </a>
                <a href="javascript:;" class="weui-tabbar__item">
                    <img src="/img/icon_tabbar.png" alt="" class="weui-tabbar__icon">
                    <p class="weui-tabbar__label">分类</p>
                </a>
                <a href="/member" class="weui-tabbar__item">
                    <img src="/img/icon_tabbar.png" alt="" class="weui-tabbar__icon">
                    <p class="weui-tabbar__label">会员</p>
                </a>
            </div>
        </div>
    </div>
</div>


        </div>
        <script type="text/javascript" src="//weui.io/zepto.min.js"></script>
        <script type="text/javascript" src="//res.wx.qq.com/open/libs/weuijs/1.1.2/weui.min.js"></script>
        <script type="text/javascript">
            $(function(){
                $('.weui-tabbar__item').on('click', function () {
                    $(this).addClass('weui-bar__item_on').siblings('.weui-bar__item_on').removeClass('weui-bar__item_on');
                });
            });
        </script>

    </body>
</html>