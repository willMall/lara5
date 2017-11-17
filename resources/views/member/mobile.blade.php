
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <title>填写资料</title>
        <link rel="stylesheet" href="//res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
        <link rel="stylesheet" href="/css/app.css"/>
    </head>
    <body ontouchstart>
        <div class="container" id="container">
            <div class="page js_show">
                <div class="page__bd" style="height: 100%;">
                    <div class="weui-tab">
                        <div class="weui-tab__panel">
                            <form id="form" method="post" action="/member/safe/mobile">
                                <div class="weui-cells weui-cells_form">
                                    <div class="weui-cell">
                                        <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
                                        <div class="weui-cell__bd">
                                            <input id="mobile" class="weui-input" type="tel" name="mobile" required pattern="REG_MOBILE" placeholder="输入您的手机号码" emptyTips="请输入手机号码" notMatchTips="请输入正确的手机号码">
                                        </div>
                                        <div class="weui-cell__ft">
                                            <i class="weui-icon-warn"></i>
                                        </div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
                                        <div class="weui-cell__bd">
                                            <input id="password" class="weui-input" type="password" name="password" required placeholder="输入你的密码" emptyTips="输入你的密码" notMatchTips="输入你的密码">
                                        </div>
                                        <div class="weui-cell__ft">
                                            <i class="weui-icon-warn"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="weui-btn-area">
                                    <a id="submit" href="javascript:" class="weui-btn weui-btn_primary">提交</a>
                                </div>
                            </form>
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
                            <a href="/member" class="weui-tabbar__item weui-bar__item_on">
                                <img src="/img/icon_tabbar.png" alt="" class="weui-tabbar__icon">
                                <p class="weui-tabbar__label">会员</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="//cdn.bootcss.com/zepto/1.2.0/zepto.min.js"></script>
        <script type="text/javascript" src="//res.wx.qq.com/open/libs/weuijs/1.1.2/weui.min.js"></script>
        <script type="text/javascript">
            $(function(){
                var regexp = {
                    regexp: {
                        MOBILE:/^1[3|4|5|7|8][0-9]{9}$/
                    }
                };
                weui.form.checkIfBlur('#form', regexp);
                document.querySelector('#submit').addEventListener('click', function () {
                    weui.form.validate('#form', function (error) {
                        if (!error) {
                            $.post('/api/member/bind', { openid:'{{$openid->openid}}', mobile: $("#mobile").val(), password: $("#password").val() }, function(response){
                              console.log(response);
                            })
                        }
                    }, regexp);
                });

            });
        </script>

    </body>
</html>