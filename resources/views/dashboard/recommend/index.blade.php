<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>商品推荐列表</title>
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
                        {!!Request::get('keyword')?'<span class="glyphicon glyphicon-search" aria-hidden="true"></span> 关键字<code>'.Request::get('keyword').'</code>搜索结果':'<span class="glyphicon glyphicon-check" aria-hidden="true"></span> 商品推荐列表'!!}
                        <span style="float:right">
                            <form class="navbar-form panel-form" method="get" action="/dashboard/recommend">
                             <input type="hidden" name="type" value="{{Request::get('type')}}">
                                <input type="text" id="keyword"  name="keyword"  value="{{Request::get('keyword')}}" class="form-control" placeholder="请输入商品名称或分类名称">
                                <button id="search_btn" class="btn btn-info" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> 查询</button>
                                <a href="/dashboard/recommend/show" class="btn btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 推荐商品</a>
                                <a href="javascript:void(0);" id="reco_del" class="btn btn-primary"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> 删除选中</a>
                                <a href="javascript:void(0);" id="reco_sort" class="btn btn-primary"><span class="glyphicon glyphicon-sort" aria-hidden="true"></span> 排序</a>
                            </form>
                        </span>

                        </h3>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll" ></th>
                                <th>商品名称</th>
                                <th>所属分类</th>
                                <th>序号</th>
                                <th>推荐时间</th>
                                <th>
                                <select id="sel_btn" class="form-control" style="width: auto;">
                                    @forelse ($type as $key=>$val)
                                    <option {{Request::get('type')==$key?"selected":''}} value="{{$key}}">{{$val}}</option>
                                       @empty
                                     <option value="">暂无分类</option>
                                    @endforelse
                                        </select>
                                </th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($items as $info)
                        <tr>
                            <td><input type="checkbox" value="{{$info->id}}" name="ids[]" ></td>
                            <td><span data-toggle="tooltip" data-placement="bottom" title="{{$info->name}}">{{str_limit($info->name,20)}}</span></td>
                            <td><span data-toggle="tooltip" data-placement="bottom" title="{{$info->cname}}">{{str_limit($info->cname,20)}}</span></td>
                            <td><input name="sort[]" minlength="1" maxlength="10"  class="form-control" onkeyup="this.value=this.value.replace(/[^\d]/g,'') " onafterpaste="this.value=this.value.replace(/[^\d]/g,'')" style="width:50%;text-align: center;" type="text" value="{{$info->sort}}"></td>
                            <td>{{$info->created_at}}</td>
                            <td>{{$info->type==1?'首页推荐':'精选推荐'}}</td>
                            <td>
                                <div class="btn-group btn-group-xs" role="group" aria-label="...">
                                <a href="javascript:void(0);"  onclick="delinfo({{$info->id}});" class="btn btn-danger">删除</a>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center">暂无数据</td>
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
    $("#checkAll").click(function(){
        $("input[name='ids[]']").prop('checked', $(this).prop('checked'));
    });
    $("#reco_sort").click(function(event) {
        var ids=[],sorts=[];
        var ids_obj=$("input[name='ids[]']");
        var sorts_obj=$("input[name='sort[]']");
         $.each(ids_obj, function(index, val) {
                 ids.push(ids_obj.eq(index).val());
                 sorts.push(sorts_obj.eq(index).val());
            });
        $.post('/dashboard/recommend/sort', {"_token":"{{csrf_token()}}","ids":ids,"sorts":sorts}, function(data, textStatus, xhr) {
                if(data.code==200) {
                    window.location.reload();
                    alertify.success(data.msg,2000);
                } else {
                    alertify.error(data.msg,2000);
                }
        },'json');
    });
    $("#sel_btn").change(function(){
        var sel_type=$(this).val();
        var keyword=$("#keyword").val();
        var linkUrl="/dashboard/recommend?type="+sel_type;
        if(keyword) linkUrl+="&keyword="+keyword;
        window.location.href=linkUrl;
    });
    $("#reco_del").click(function(){
        var obj=$("input[name='ids[]']:checked");
        var len= obj.length,ids=[];
        if(len<=0) {
            alertify.error("请选择要删除的商品",2000);
            return false;
        }
        else{
            $.each(obj, function(index, val) {
                 ids.push(obj.eq(index).val());
            });
        }
        if(confirm('您确认要删除选中的推荐商品吗？'))
        {
            $.post('/dashboard/recommend/destroy', {"_token":"{{csrf_token()}}","id":ids}, function(data, textStatus, xhr) {
                if(data.code==200) {
                    window.location.reload();
                    alertify.success(data.msg,2000);
                } else {
                    alertify.error(data.msg,2000);
                }
            },'json');
       }
    });
    function delinfo(id){
     if(id) {
        if(confirm('您确认要删除该项推荐商品吗？'))
        {
            $.post('/dashboard/recommend/destroy', {"id":id,"_token":"{{csrf_token()}}"}, function(data, textStatus, xhr) {
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