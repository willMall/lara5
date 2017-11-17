<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>新增广告</title>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/admin.css">
    <script src="https://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://cdn.bootcss.com/bootstrap-fileinput/4.4.5/css/fileinput.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.5/js/fileinput.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.5/js/locales/zh.js"></script>
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
                <form method="post" action="/dashboard/ads" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">新增广告</h3>
                            </div>
                            <div class="panel-body">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                            <label for="name">广告类型</label>
                                            <select name="type" class="form-control">
				                             <option value="1">首页广告</option>
											</select>
                                        </div>
                                      </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">广告标题</label>
                                            <input type="text" class="form-control" name="title" value="{{old('title')}}" placeholder="请输入广告标题">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">链接地址</label>
                                            <input type="text" class="form-control" name="url" value="{{old('url')}}" placeholder="请输入链接地址">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">序号</label>
                                            <input type="text" minlength="1" maxlength="10"  class="form-control" onkeyup="this.value=this.value.replace(/[^\d]/g,'') " onafterpaste="this.value=this.value.replace(/[^\d]/g,'')" name="sort" value="{{old('sort')}}" placeholder="请输入序号">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">广告图片</label>
                                            <input id="uploadAds" type="file" name="path" class="projectfile" value=""/>
                                            <p class="help-block">&nbsp;支持jpg、jpeg、png格式，大小不超过2.0M</p>
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
<script type="text/javascript">
    $("#uploadAds").fileinput({
        showUpload : false,
        showRemove : false,
        language : 'zh',
        allowedPreviewTypes: ['image'],
        allowedFileTypes: ['image'],
        allowedFileExtensions:  ['jpg', 'png','jpeg'],
        maxFileSize : 2048,

    });
</script>