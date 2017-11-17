<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>订单列表</title>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/admin.css">
    <script src="https://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://cdn.bootcss.com/alertify.js/0.3.10/alertify.core.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/alertify.js/0.3.10/alertify.default.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/alertify.js/0.3.10/alertify.min.js"></script>
</head>
<body>
  @include('dashboard.top')
    <div class="container">
        <div class="row">
        <div class="col-md-2">
          @include('dashboard.sidebar')
        </div>
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading panel-heading-custom">
                        <h3 class="panel-title panel-title-custom">
                        {!!Request::get('keyword')?'<span class="glyphicon glyphicon-search" aria-hidden="true"></span> 关键字<code>'.Request::get('keyword').'</code>搜索结果':'<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> 订单列表'!!}
                        <span style="float:right">
                            <form id="queryfrm" class="navbar-form panel-form" method="get" action="/dashboard/order">
                                <input type="hidden" name="ostatus" id="orderstatus" value="{{Request::get('ostatus')}}">
                                <input type="hidden" name="istatus" id="itemstatus" value="{{Request::get('istatus')}}">
                                <input type="text" title="请输入订单编号/用户名/手机号" id="keyword"  name="keyword"  value="{{Request::get('keyword')}}" class="form-control" placeholder="请输入订单编号/用户名/手机号">
                                <button id="search_btn" class="btn btn-info" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> 查询</button>
                            </form>
                        </span>
                        </h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>订单编号</th>
                                <th>总价(元)</th>
                                <th>卖家</th>
                                <th>买家</th>
                                <th>
                                    <select id="ostatus" >
                                         <option {{empty(Request::get('ostatus'))?"selected":''}} value="">全部</option>
                                        <option {{Request::get('ostatus')==1?"selected":''}} value="1">未支付</option>
                                        <option {{Request::get('ostatus')==2?"selected":''}} value="2">已支付</option>
                                    </select>
                                </th>
                                <th>
                                      <select id="istatus" >
                                             <option {{empty(Request::get('istatus'))?"selected":''}} value="">全部</option>
                                            <option {{Request::get('istatus')==1?"selected":''}} value="1">未发货</option>
                                            <option {{Request::get('istatus')==2?"selected":''}} value="2">待收货</option>
                                             <option {{Request::get('istatus')==3?"selected":''}} value="3">交易成功</option>
                                        </select>
                                </th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($items as $info)
                        <?php
                        $itemstatus="";
                        switch ($info->schedule) {
                            case '1':
                                $itemstatus="未发货";
                                break;
                            case '2':
                                $itemstatus="待收货";
                                break;
                            case '3':
                                $itemstatus="交易成功";
                                break;
                        }
                        ?>
                        <tr>
                             <td><span>{{$info->uuid}}</span></td>
                            <td><span style="color:red;">￥</span>{{$info->price/100}}</td>
                            <td>{{$info->name}}</td>
                            <td>{{$info->agentname}}</td>
                            <td>{{$info->status==1?'已支付':'未支付'}}</td>
                            <td>{{$itemstatus}}</td>
                            <td>{{$info->created_at}}</td>
                            <td>
                                <div class="btn-group btn-group-xs" role="group" aria-label="...">
                                <a href="/dashboard/order/show/{{$info->id}}.html" style="margin-right:5px;" class="btn btn-primary">查看详情</a>
                                @if($info->status==1&&$info->schedule==1)
                                 <a href="javascript:void(0);" onclick="fahuo({{$info->id}});" class="btn btn-success">发货</a>
                                 @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center">暂无数据</td>
                            </tr>
                       @endforelse
                        </tbody>
                    </table>   
                    </div> 
                    <div class="panel-footer">
                        <span style="float:left" class="text-left">共 {{$items->count()}} 条信息</span>
                        <span style="float: right" class="text-right">{!!$items->appends(['keyword' => Request::get('keyword'),'ostatus' => Request::get('ostatus'),'istatus' => Request::get('istatus'),'type'=>Request::get('type')])->render() ?: '暂无分页'!!}</span>
                        <div class="clearfix "></div>
                     </div>
                </div>
            </div>    
        </div>    
    </div>   
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" style="margin-top: 10%;">
        <div class="modal-dialog" role="document">
            <form id="boxfrm">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" id="infoid" name="id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">发货</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">备注:</label>
                            <input type="text" name="remarks"   class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" id="fahuo_btn" class="btn btn-primary">保存</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<script>
$('[data-toggle="tooltip"]').tooltip();
    function fahuo(id) {
        if(id) {
            $("#infoid").val(id);
            $('#myModal').modal();
        }
    }
    $("#ostatus").change(function(){
        var status=$(this).val();
        $("#orderstatus").val(status);
        $("#queryfrm").submit();
    });
    $("#istatus").change(function(){
        var status=$(this).val();
        $("#itemstatus").val(status);
        $("#queryfrm").submit();
    });
    $("#fahuo_btn").click(function(){
        $.post('/dashboard/order/send', $("#boxfrm").serialize(), function(data, textStatus, xhr) {
            $('#myModal').modal('hide');
            if(data.code==200) {
                window.location.reload();
                alertify.success(data.msg,2000);
            } else {
                alertify.error(data.msg,2000);
            }
        },'json');
    });
</script>