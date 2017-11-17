<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>订单详情</title>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/admin.css">
    <script src="https://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
@include('dashboard.top')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
              @include('dashboard.sidebar')
            </div>
            <div class="col-md-10">
                <form class="form-horizontal">
                        <div class="panel panel-default">
                         <div class="panel-heading">
                                <h3 class="panel-title">商品信息</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>商品图片</th>
                                            <th>商品名称</th>
                                            <th>单价(元)</th>
                                            <th>数量</th>
                                            <th>总价</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($item->details as $info)
                                    <tr>
                                        <td>
                                        <img src="/storage/{{$info->thumb}}" title="{{$info->name}}" alt="{{$info->name}}" style="width: 60px;height: 60px;">
                                        </td>
                                        <td><span data-toggle="tooltip" data-placement="bottom" title="{{$info->cname}}">{{$info->name}}</span></td>
                                        <td><span style="color:red;">￥</span>{{$info->price/100}}</td>
                                        <td>{{$info->qty}}</td>
                                        <td><span style="color:red;">￥</span>{{($info->price/100)*$info->qty}}</td>
                                    </tr>
                                   @endforeach
                                   <tr>
                                     <td colspan="5" style="text-align: right;">订单总价：<span style="color:red;">￥</span>
                                     {{$item->price/100}}
                                     </td>
                                   </tr>
                                    </tbody>
                                </table>   
                                </div> 
                            </div>

                            <div class="panel-heading">
                                <h3 class="panel-title">订单信息</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">创建时间</label>
                                     <div class="col-sm-10">
                                     <p class="form-control-static">{{$item->created_at}}</p>
                                   </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">支付状态</label>
                                     <div class="col-sm-10">
                                     <p class="form-control-static">{{$item->status==1?'已支付':'未支付'}}</p>
                                   </div>
                                </div>
                            </div>

                            <div class="panel-heading">
                                <h3 class="panel-title">买家信息</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">用户名</label>
                                     <div class="col-sm-10">
                                     <p class="form-control-static">{{$item->name}}</p>
                                   </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-sm-2 control-label">手机号</label>
                                     <div class="col-sm-10">
                                     <p class="form-control-static">{{$item->mobile}}</p>
                                   </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-sm-2 control-label">收货地址</label>
                                     <div class="col-sm-10">
                                     <p class="form-control-static">{{$item->address}}</p>
                                   </div>
                                </div>
                                @if($item->status==1)
                                 <div class="form-group">
                                    <label class="col-sm-2 control-label">付款时间</label>
                                     <div class="col-sm-10">
                                     <p class="form-control-static">{{$item->updated_at}}</p>
                                   </div>
                                </div>
                                @endif
                                <div class="col-md-12">
                                     <div class="form-group" style="text-align: center;">
                     <a href="javascript:history.back();" class="btn btn-default">返回</a>
									</div>
								</div>
                            </div>
                        </div>
                 </form>
            </div>
        </div>
    </div>
</body>
</html>