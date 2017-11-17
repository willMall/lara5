<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>用户列表</title>
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
                        {!!Request::get('keyword')?'<span class="glyphicon glyphicon-search" aria-hidden="true"></span> 关键字<code>'.Request::get('keyword').'</code>搜索结果':'<span class="glyphicon glyphicon-user" aria-hidden="true"></span> 用户列表'!!}
                        <span style="float:right">
                            <form class="navbar-form panel-form" method="get" action="/dashboard/user">
                                <input type="text" id="keyword"  name="keyword"  value="{{Request::get('keyword')}}" class="form-control" placeholder="请输入手机号或邮箱">
                                <button id="search_btn" class="btn btn-info" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> 查询</button>
                                <a href="javascript:void(0);" id="role_add" class="btn btn-primary"><span class="glyphicon glyphicon-plus"  aria-hidden="true"></span> 添加</a>
                            </form>
                        </span>
                        </h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>手机号</th>
                                <th>邮箱</th>
                                <th>用户角色</th>
                                <th>注册时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($items as $info)
                        <tr>
                            <td>{{$info->mobile}}</td>
                            <td>{{$info->email}}</td>
                            <td><span data-roleids="{{$info->roleids}}">{{$info->rolename?$info->rolename:'暂无'}}<span></td>
                            <td>{{$info->created_at}}</td>
                            <td>
                                <div class="btn-group btn-group-xs" role="group" aria-label="...">
                                <a href="javascript:void(0);"  onclick="boxinfo({{$info->id}},this);" style="margin-right:5px;" class="btn btn-success">分配角色</a>
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
                        <h4 class="modal-title">角色分配</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">选择角色&nbsp;&nbsp;</label>
                                @foreach ($roleList as $val)
                                <input type="checkbox" name="rolename[]" data-id="{{$val->id}}" value="{{$val->name}}">&nbsp;{{$val->name}}
                                @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" id="role_btn" class="btn btn-primary">保存</button>
                    </div>
                </div>
            </form>
        </div>
    </div>   
     <div id="roleModal" class="modal fade" tabindex="-1" role="dialog" style="margin-top: 10%;">
        <div class="modal-dialog" role="document">
            <form id="rolefrm">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">添加角色</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                        <label for="recipient-name" class="control-label">角色名称 </label>
                           <input type="text" class="form-control" name="name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" id="roleadd_btn" class="btn btn-primary">保存</button>
                    </div>
                </div>
            </form>
        </div>
    </div>   
</body>
</html>
<script>
    $('[data-toggle="tooltip"]').tooltip();
    function boxinfo(id,obj) {
        if(id) {
            var roles=[]; 
            roles=$(obj).parents('tr').eq(0).find('td').eq(2).find('span').data('roleids');
            $("input[name='rolename[]']").prop('checked', false)
            var roleobj=$("input[name='rolename[]']");
            $.each(roleobj, function(index, val) {
                if($.inArray(roleobj.eq(index).data('id'),roles)>=0)
                {
                    roleobj.eq(index).prop('checked', true);
                }
            });
            $("#infoid").val(id);
            $('#myModal').modal();
        }
    }
    $("#role_btn").click(function(event) {
        $.post('/dashboard/user/userroleadd', $("#editfrm").serialize(), function(data, textStatus, xhr) {
                if(data.code==200) {
                    window.location.reload();
                    alertify.success(data.msg,2000);
                } else {
                    alertify.error(data.msg,2000);
                }
        },'json');
    });
   $("#role_add").click(function() {
       $('#roleModal').modal();
   });
    $("#roleadd_btn").click(function(event) {
        $.post('/dashboard/user/roleadd', $("#rolefrm").serialize(), function(data, textStatus, xhr) {
                if(data.code==200) {
                    window.location.reload();
                    alertify.success(data.msg,2000);
                } else {
                    alertify.error(data.msg,2000);
                }
        },'json');
    });
</script>