<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>图片上传</title>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdn.bootcss.com/bootstrap-fileinput/4.4.5/css/fileinput.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css"/>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.5/js/plugins/sortable.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.5/js/plugins/purify.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.5/js/fileinput.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.5/themes/fa/theme.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.5/js/locales/zh.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/admin.css">
    <style type="text/css">
    .krajee-default.file-preview-frame .kv-file-content {
     width: 190px;
     height: 137px;
    }
    </style>
</head>
<body>
@include('dashboard.top')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
              @include('dashboard.sidebar')
            </div>
            <div class="col-md-10">
                <form class="form-horizontal" enctype="multipart/form-data">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">商品图片上传</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <form enctype="multipart/form-data">
                                        <div class="file-loading">
                                            <input id="itemUpload" name="files" type="file" multiple>
                                        </div>
                                        <div id="errorBlock" class="help-block"></div>
                                    </form>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                     <div class="form-group" style="text-align: center;">
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
var previewList=[],previewConfig=[],tmp=[];
$(function(){
    $.post('/dashboard/item/getpic', {"id": "{{$data->id}}","_token":"{{csrf_token()}}"}, function(data, textStatus, xhr) {
        var plist=data.previewList;
        var pconfig=data.previewConfig;
       $.each(plist, function(index, val) {
            previewList.push(val);
            previewConfig.push(pconfig[index]);
       });
    $('#itemUpload').fileinput({
        theme: 'fa',
        language: 'zh',
        showRemove:false,
        showClose:false,
        uploadAsync:true,
        showAjaxErrorDetails:false,
        allowedFileExtensions: ['jpg', 'png', 'gif'],
        allowedPreviewTypes: ['image'],
        allowedFileTypes: ['image'],
        maxFileSize: 2048,
        maxFileCount: 4,
        enctype: 'multipart/form-data',
        validateInitialCount:true,
        uploadUrl: '/dashboard/file/upload',
        uploadExtraData:{"type":"files","id": "{{$data->id}}","own":1,"_token":"{{csrf_token()}}"},
        deleteUrl: '/dashboard/file/delete',
        deleteExtraData:{"id": "{{$data->id}}","_token":"{{csrf_token()}}"},
        initialPreviewAsData: true,
        elErrorContainer: '#errorBlock',
        overwriteInitial: false,
        initialPreview: previewList,
        initialPreviewConfig:previewConfig,
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
     });
    },'json');
});
$("#itemUpload").on("fileuploaded", function (event, data,id, index) {  
    console.log('fileuploaded');
    tmp.push(data.response.path);
    console.log(data.response.path);
     });
//编辑图片的删除方法
$('#itemUpload').on('filebeforedelete', function(event, data, msg) {
     console.log("filebeforedelete");
    var abort = true;
　　if (confirm("确定删除此图片?")) {
　　　　abort = false;
　　}
　　return abort;
});
//上传成功后图片的删除方法
$('#itemUpload').on('filesuccessremove', function (event, id) {
     console.log("filesuccessremove");
　　if (confirm("确定删除此图片?")) {
        var imgsrc=$("#"+id);
        var index=$('.file-preview-success').index(imgsrc);
        var path=tmp[index];
        $.post('/dashboard/file/delete', {"id": "{{$data->id}}","_token":"{{csrf_token()}}","key":path}, function(data, textStatus, xhr) {
            if(data.status) {tmp.splice(index,1); return true;}
            else return false;
        });
　　}
　　else return false;
});
//ajax 上传前验证方法
$('#itemUpload').on('filepreajax', function(event, previewId, index) {
    console.log("filepreajax");
    if(previewId==undefined)
    {
      $('.kv-upload-progress').hide();
      $('#itemUpload').fileinput('enable');
      $("#errorBlock").append("<button type=\"button\" onclick=\"hideBox(this);\" class=\"close kv-error-close\">&times;</button>");
      $("#errorBlock").append("<ul><li><b>请选择要上传的文件!</b></li></ul>");
      $("#errorBlock").show();
      return false;
   }
});
function hideBox(ob)
{
   $(ob).parent('#errorBlock').fadeOut('slow');
}
</script>
