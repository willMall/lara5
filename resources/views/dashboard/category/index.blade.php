<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>分类列表</title>
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
                            <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> 分类信息
                            <span style="float:right">
                                        <a href="/dashboard/category/create" class="btn btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加</a>
                                </span>
                        </h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>分类id</th>
                                <th>分类名称</th>
                                <th>创建时间</th>
                                <th>更新时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($data as $info)
                        <?php $name=str_limit($info->name,20);
                         if($info->depth==2) $name='<span>&nbsp;</span>|--'.'<span>&nbsp;</span>'.$name;
                         if($info->depth==3) $name='<span>&nbsp;&nbsp;&nbsp;</span>|--'.'<span>&nbsp;</span>'.$name;
                        ?>
                        <tr>
                            <td>{{$info->id}}</td>
                            <td><span data-toggle="tooltip" data-placement="bottom" title="{{$info->name}}">{!!$name!!}</span></td>
                            <td>{{$info->created_at}}</td>
                            <td>{{$info->updated_at}}</td>
                            <td>
                                <div class="btn-group btn-group-xs" role="group" aria-label="...">
                                <a href="javascript:void(0);" style="margin-right:5px;" class="btn btn-success" onclick="editinfo({{$info->id}},this);">修改</a>
                                 <a href="javascript:void(0);" style="margin-right:5px;" class="btn btn-primary" onclick="movenode({{$info->id}},this);">移动</a>   
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
                        <h4 class="modal-title">编辑分类</h4>
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
     <div id="moveModal" class="modal fade" tabindex="-1" role="dialog" style="margin-top: 10%;">
        <div class="modal-dialog" role="document">
            <form id="movefrm">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" id="nodeid" name="nodeid">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">移动分类</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">当前分类名称:</label>
                            <input type="text" readonly="readonly" id="nodename"  class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">目标分类名称:</label>
                                <select id="tar_id" name="tnodeid" class="form-control">
                                @forelse ($nodes as $info)
                                 <?php $name=$pname=$info->name;
                                     if($info->depth==1) $name='<span>&nbsp;</span>|--'.$name;
                                     if($info->depth==2) $name='<span>&nbsp;&nbsp;&nbsp;</span>|--'.$name;
                                      if($info->depth==3) $name='<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>|--'.$name;
                                    ?>
                                  <option data-name="{{$pname}}" value="{{$info['id']}}">{!!$name!!}</option>
                                   @empty
                                 <option value="0">暂无分类</option>
                                @endforelse
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">移动位置:</label>
                            <input type="radio"  name="movepos" value="1" checked="checked">最左边
                            <input type="radio"  name="movepos" value="2">最右边
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" id="move_btn" class="btn btn-primary">保存</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<script>
    $('[data-toggle="tooltip"]').tooltip();
    function editinfo(id,ob) {
        if(id) {
            var name=$(ob).parents('tr').find('td').eq(1).find('span').eq(0).attr('data-original-title');
            $("#infoid").val(id);
            $("#name").val(name);
            $('#myModal').modal();
        }
    }
    function movenode(id,ob) {
        if(id) {
            var name=$(ob).parents('tr').find('td').eq(1).find('span').eq(0).attr('data-original-title');
            $("#nodeid").val(id);
            $("#nodename").val(name);
            $("#tar_id").find("option").attr('style', '');
            $("#tar_id option[value='"+id+"']").css({"color":"red","fontWeight":"bold"});
            $('#moveModal').modal();
        }
    }
    $("#edit_btn").click(function(){
        $.post('/dashboard/category/edit', $("#editfrm").serialize(), function(data, textStatus, xhr) {
            $('#myModal').modal('hide');
            if(data.code==200) {
                window.location.reload();
                alertify.success(data.msg,2000);
            } else {
                alertify.error(data.msg,2000);
            }
        },'json');
    });
    $("#move_btn").click(function(){
        $.post('/dashboard/category/moved', $("#movefrm").serialize(), function(data, textStatus, xhr) {
            $('#moveModal').modal('hide');
            if(data.code==200) {
                window.location.reload();
                alertify.success(data.msg,2000);
            } else {
                alertify.error(data.msg,2000);
            }
        },'json');
    });
    function delinfo(id){
     if(id) {
        if(confirm('您确认删除该分类及其下面的子分类吗？'))
        {
            $.post('/dashboard/category/destroy', {"id":id,"_token":"{{csrf_token()}}"}, function(data, textStatus, xhr) {
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
</script>