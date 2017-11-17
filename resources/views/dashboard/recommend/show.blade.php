<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>推荐商品列表</title>
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
                    <div class="panel-heading">
                        <h3 class="panel-title">推荐商品</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-6">
                           <div class="form-group">
                                <label for="name">推荐类型&nbsp;&nbsp;</label>
                                <select id="reco_type">
                                 @forelse ($type as $key=>$val)
                                    <option {{Request::get('type')==$key?"selected":''}} value="{{$key}}">{{$val}}</option>
                                       @empty
                                     <option value="">暂无分类</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                         <div class="col-md-10">
                             <div class="form-group" style="text-align: center;">
                             <button type="button" id="reco_btn" class="btn btn-primary">确认推荐</button>
                                 <a href="javascript:history.back();" class="btn btn-default">返回</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading panel-heading-custom">
                        <h3 class="panel-title panel-title-custom">
                        {!!Request::get('keyword')?'<span class="glyphicon glyphicon-search" aria-hidden="true"></span> 关键字<code>'.Request::get('keyword').'</code>搜索结果':'<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> 商品列表'!!}
                        <span style="float:right">
                            <form class="navbar-form panel-form" method="get" action="/dashboard/recommend/show">
                             <input type="hidden" name="type" value="{{Request::get('type')}}">
                                <input type="text" id="keyword"  name="keyword"  value="{{Request::get('keyword')}}" class="form-control" placeholder="请输入商品名称或分类名称">
                                <button id="search_btn" class="btn btn-info" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> 查询</button>
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
                                <th>单价(元)</th>
                                <th>库存</th>
                                <th>创建时间</th>
                                <th>更新时间</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($items as $info)
                        <tr>
                            <td><input type="checkbox" value="{{$info->id}}" name="ids[]" ></td>
                            <td><span data-toggle="tooltip" data-placement="bottom" title="{{$info->name}}">{{str_limit($info->name,30)}}</span></td>
                            <td><span data-toggle="tooltip" data-placement="bottom" title="{{$info->cname}}">{{str_limit($info->cname,30)}}</span></td>
                            <td>{{$info->price/100}}</td>
                            <td>{{$info->stock}}</td>
                            <td>{{$info->created_at}}</td>
                            <td>{{$info->updated_at}}</td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center">暂无商品</td>
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
    $("#reco_btn").click(function(){
        var obj=$("input[name='ids[]']:checked");
        var len= obj.length,ids=[];
        var type=$("#reco_type").val();
        if(len<=0) {
            alertify.error("请选择要推荐的商品",2000);
            return false;
        }
        else{
            $.each(obj, function(index, val) {
                 ids.push(obj.eq(index).val());
            });
        }
        $.post('/dashboard/recommend/create', {"_token":"{{csrf_token()}}","ids":ids,"type":type}, function(data, textStatus, xhr) {
            $('#myModal').modal('hide');
            if(data.code==200) {
                window.location.reload();
                alertify.success(data.msg,2000);
            } else {
                alertify.error(data.msg,2000);
            }
        },'json');
    });
    $("#checkAll").click(function(){
        $("input[name='ids[]']").prop('checked', $(this).prop('checked'));
    });
    $("#reco_type").change(function(){
        var sel_type=$(this).val();
        var keyword=$("#keyword").val();
        var linkUrl="/dashboard/recommend/show?type="+sel_type;
        if(keyword) linkUrl+="&keyword="+keyword;
        window.location.href=linkUrl;
    });
</script>