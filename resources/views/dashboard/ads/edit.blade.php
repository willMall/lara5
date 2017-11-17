<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>编辑广告</title>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/admin.css">
    <script src="https://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://cdn.bootcss.com/bootstrap-fileinput/4.4.5/css/fileinput.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.5/js/fileinput.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.5/js/locales/zh.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.5/themes/fa/theme.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css"/>
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
                <form method="post" action="/dashboard/ads/{{$data->id}}" enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        {!! csrf_field() !!}
                        <input type="hidden" id="picpath" name="path" value="{{$data->path}}">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">编辑广告</h3>
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
                                            <input type="text" class="form-control" name="title" value="{{$data->title}}" placeholder="请输入广告标题">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">链接地址</label>
                                            <input type="text" class="form-control" name="url" value="{{$data->url}}" placeholder="请输入链接地址">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">序号</label>
                                            <input type="text" minlength="1" maxlength="10"  class="form-control" onkeyup="this.value=this.value.replace(/[^\d]/g,'') " onafterpaste="this.value=this.value.replace(/[^\d]/g,'')" name="sort" value="{{$data->sort}}" placeholder="请输入序号">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">广告图片</label>
                                            <input id="uploadAds" type="file" name="path" />
                                            <div id="errorBlock" class="help-block"></div>
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
$(function(){
    var previewList=[],previewConfig=[];
    var path="{{$data->path}}";
    if(path){
    var picname=path.substring(7);
    previewList.push('/storage/'+path);
    previewConfig.push({"key":path,"caption":picname});
    console.log(previewList);
    console.log(previewConfig);
    }
        $("#uploadAds").fileinput({
            theme: 'fa',
            uploadAsync: false, //同步上传  
            showUpload : false,
            showRemove : false,
            showAjaxErrorDetails:false,
            language : 'zh',
            allowedPreviewTypes: ['image'],
            allowedFileTypes: ['image'],
            allowedFileExtensions:  ['jpg', 'png','jpeg'],
            initialPreviewAsData: true,
            initialPreview: previewList,
            initialPreviewConfig:previewConfig,
            deleteUrl: '/dashboard/ads/delete',
            deleteExtraData:{"id": "{{$data->id}}","path":"{{$data->path}}","_token":"{{csrf_token()}}"},
            elErrorContainer: '#errorBlock',
            maxFileSize : 2048,
            slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
        });
});
 //编辑图片的删除方法
$('#uploadAds').on('filebeforedelete', function(event, data, msg) {
     console.log("filebeforedelete");
    var abort = true;
　　if (confirm("确定删除此图片?")) {
　　　　abort = false;
　　}
　　return abort;
});
//删除图片成功后回调
$('#uploadAds').on('filedeleted', function(event, key) {  
    $("#picpath").val('');
});
</script>