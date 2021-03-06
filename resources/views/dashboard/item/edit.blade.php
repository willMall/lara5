<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>编辑商品</title>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/admin.css">
    <script src="https://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://cdn.bootcss.com/summernote/0.8.8/summernote.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/summernote/0.8.8/summernote.min.js"></script>
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
                <form method="post" action="/dashboard/item/edit">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" value="{{$data->id}}">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">编辑商品</h3>
                            </div>
                            <div class="panel-body">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                            <label for="name">请选择分类</label>
                                            <select name="category_id" class="form-control">
                                            @forelse ($nodes as $info)
                                             <?php $name=$pname=$info->name;
						                         if($info->depth==1) $name='<span>&nbsp;</span>|--'.$name;
						                         if($info->depth==2) $name='<span>&nbsp;&nbsp;&nbsp;</span>|--'.$name;
						                          if($info->depth==3) $name='<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>|--'.$name;
						                        ?>
											  <option data-name="{{$pname}}" value="{{$info->id}}" {{$info->id==$data->category_id?'selected="selected"':""}} >{!!$name!!}</option>
											   @empty
				                             <option value="">暂无分类</option>
					                        @endforelse
											</select>
                                        </div>
                                      </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">商品名称</label>
                                            <input type="text" class="form-control" name="name" value="{{$data->name}}" placeholder="请输入商品名称">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">商品价格(元)</label>
                                            <input type="text" class="form-control" name="price" value="{{$data->price/100}}" placeholder="请输入价格">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">商品库存</label>
                                            <input type="text" class="form-control" name="stock" value="{{$data->stock}}" placeholder="请输入库存">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">商品详情</label>
                                            <textarea id="summernote" name="details">
                                            {{$data->details}}
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                         <div class="form-group" style="text-align: center;">
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
  <script>
    $(document).ready(function() {
        $('#summernote').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']],
                ['myplugin', ['aceCodeEditor']]
            ]
        });
    });
  </script>