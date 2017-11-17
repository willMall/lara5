<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>广告列表</title>
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
                @if (session('msg'))
                     <div class="alert {{(session('code')==200)?'alert-success':'alert-danger'}} alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ session('msg') }}
                     </div>
                    @endif
                <div class="panel panel-default">
                    <div class="panel-heading panel-heading-custom">
                        <h3 class="panel-title panel-title-custom">
                        <span class="glyphicon glyphicon-picture" aria-hidden="true"></span> 广告列表
                        <span style="float:right">
                            <div class="navbar-form panel-form">
                               <a href="/dashboard/ads/create" class="btn btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加</a>
                            </div>
                        </span>

                        </h3>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                        <thead>
                            <tr valign="middle">
                                <th>广告图片</th>
                                <th>广告标题</th>
                                <th>链接地址</th>
                                <th>序号</th>
                                <th>类型</th>
                                <th>创建时间</th>
                                <th>更新时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($items as $info)
                        <tr>
                            <td><img style="width:100px;height: 100px;" src="/storage/{{$info->path}}" alt="{{$info->title}}"></td>
                            <td><span data-toggle="tooltip" data-placement="bottom" title="{{$info->title}}">{{str_limit($info->title,20)}}</span></td>
                             <td><span data-toggle="tooltip" data-placement="bottom" title="{{$info->url}}">{{str_limit($info->url,20)}}</span></td>
                            <td>{{$info->sort}}</td>
                            <td>首页广告</td>
                            <td>{{$info->created_at}}</td>
                            <td>{{$info->updated_at}}</td>
                            <td>
                                <div class="btn-group btn-group-xs" role="group" aria-label="...">
                                <a href="/dashboard/ads/{{$info->id}}/edit" style="margin-right:5px;" class="btn btn-success">修改</a>
                                <a href="javascript:void(0);"  onclick="delinfo({{$info->id}});" class="btn btn-danger">删除</a>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center">暂无数据</td>
                            </tr>
                       @endforelse
                        </tbody>
                    </table>   
                    </div> 
                    <div class="panel-footer">
                        <span style="float:left" class="text-left">共 {{$items->count()}} 条信息</span>
                        <span style="float: right" class="text-right">{!!$items->appends(['keyword' => Request::get('keyword'),'type'=>Request::get('type')])->render() ?: '暂无分页'!!}</span>
                        <div class="clearfix "></div>
                     </div>
                </div>
            </div>    
        </div>    
    </div>   
</body>
</html>
<script>
    $('[data-toggle="tooltip"]').tooltip();
    function delinfo(id){
     if(id) {
        if(confirm('您确认删除该项吗？'))
        {
            $.ajax({
                url: '/dashboard/ads/'+id,
                type: 'DELETE',
                dataType: 'json',
                data: {_token: '{{csrf_token()}}'},
            })
            .done(function(data) {
                if(data.code==200)
                {
                    alertify.success(data.msg);
                    window.location.reload();
                }
                else{alertify.error(data.msg);}
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
        }
     }
    }
</script>