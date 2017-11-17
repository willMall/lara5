<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>商品列表</title>
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
                        {!!Request::get('keyword')?'<span class="glyphicon glyphicon-search" aria-hidden="true"></span> 关键字<code>'.Request::get('keyword').'</code>搜索结果':'<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> 商品列表'!!}
                        <span style="float:right">
                            <form class="navbar-form panel-form" method="get" action="/dashboard/item">
                                <input type="text" id="keyword"  name="keyword"  value="{{Request::get('keyword')}}" class="form-control" placeholder="请输入商品名称或分类名称">
                                <button id="search_btn" class="btn btn-info" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> 查询</button>
                                <a href="/dashboard/item/create" class="btn btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加</a>
                            </form>
                        </span>
                        </h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>商品名称</th>
                                <th>所属分类</th>
                                <th>单价(元)</th>
                                <th>库存</th>
                                <th>创建时间</th>
                                <th>更新时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($items as $info)
                        <tr>
                            <td><span data-toggle="tooltip" data-placement="bottom" title="{{$info->name}}">{{str_limit($info->name,20)}}</span></td>
                            <td><span data-toggle="tooltip" data-placement="bottom" title="{{$info->cname}}">{{str_limit($info->cname,20)}}</span></td>
                            <td><span style="color:red;">￥</span>{{$info->price/100}}</td>
                            <td>{{$info->stock}}</td>
                            <td>{{$info->created_at}}</td>
                            <td>{{$info->updated_at}}</td>
                            <td>
                                <div class="btn-group btn-group-xs" role="group" aria-label="...">
                                <a href="/dashboard/item/edit/{{$info->id}}.html" style="margin-right:5px;" class="btn btn-success">修改</a>
                                <a href="/dashboard/item/show/{{$info->id}}.html" style="margin-right:5px;" class="btn btn-primary">查看</a>
                                 <a href="/dashboard/item/upload/{{$info->id}}.html" style="margin-right:5px;" class="btn btn-info">上传图片</a>
                                <a href="javascript:void(0);"  onclick="delinfo({{$info->id}});" class="btn btn-danger">删除</a>
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
                        <span style="float: right" class="text-right">{!!$items->appends(['keyword' => Request::get('keyword'),'type'=>Request::get('type')])->render() ?: '暂无分页'!!}</span>
                        <div class="clearfix "></div>
                     </div>
                </div>
            </div>    
        </div>    
    </div>   
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" style="margin-top: 10%;">
        <div class="modal-dialog" role="document">
            <form id="editfrm">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" id="infoid" name="id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">图片上传</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">分类名称:</label>
                            <input type="text" name="name" id="name"  class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" id="edit_btn" class="btn btn-primary">保存</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<script>
    $('[data-toggle="tooltip"]').tooltip();
    function delinfo(id){
     if(id) {
        if(confirm('您确认删除该条记录吗？'))
        {
            $.post('/dashboard/item/destroy', {"id":id,"_token":"{{csrf_token()}}"}, function(data, textStatus, xhr) {
            if(data.code==200) {
                window.location.reload();
                alertify.success(data.msg,2000);
            } else {
                alertify.error(data.msg,2000);
            }
            },'json');
        }
     }
    }
    function itemUpload(id) {
        if(id) {
            $("#infoid").val(id);
            $('#myModal').modal();
        }
    }
    $(function(){
        $.ajax({
            url: 'http://kf.mdlar.com/admin/item',
            type: 'post',
            dataType: 'json',
            data: {_token: 'HO412vKV8mhLwimFKKSssmjOYFBEGNIUngELqJJP'},
        })
        .done(function(data) {
            console.log(data);
            console.log("success");
        })
        .fail(function(error) {
            console.log(error);
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
    });
</script>