<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>新增分类</title>
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
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <form method="post" action="/dashboard/category/create">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">新增分类</h3>
                            </div>
                            <div class="panel-body">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                            <label for="name">请选择父级分类</label>
                                            <select name="parent_id" class="form-control">
                                            @forelse ($data as $info)
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
                                      </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">分类名称</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" placeholder="请输入产品名称">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                         <div class="form-group" style="text-align: center;margin-top: 15px;">
										     <button type="submit" class="btn btn-primary">保存</button>
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